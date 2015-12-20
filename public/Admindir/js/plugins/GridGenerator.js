var GridGenerator = function(){
    this.structure = [];
    this.container;
    this.screenHeight;
    this.contextMenuIsOpen = false;
    this.selectedRowIndex = -1;
    this.contextmenuUlElement;
    this.lastcontextmenuColumn;

    this.setContainer = function(container){
        this.container = container;
    }

    this.setJson = function(json){
        this.structure = $.parseJSON(json);
    };

    this.init = function(){
        var self = this;
        self.screenHeight = $(window).height();

        var offset = self.container.offset();
        
        self.container.css('min-height', (self.screenHeight - offset.top) - 15);
        self.mainContainerClickEvents();

        self.draw();
    };

    this.initEvents = function(){
        var self = this;
        
        // clik on free space
        self.container.mousedown(function(){
            self.selectedRowIndex = -1;
        });
    };

    this.mainContainerClickEvents = function(){
        var self = this;       
    
        self.container.on("contextmenu", function (e) {
            self.contextMenu(e);
            self.selectedRowIndex = -1;
            return false;
        });

    };

    this.contextMenu = function(event, isColumn, htmlColumn){
        var self = this;

        if (self.contextMenuIsOpen == true) {
            //return false;
            self.closeContextMenu();
        }

        self.contextMenuIsOpen = true;

        self.contextmenuUlElement = $('<ul id="contextMenu" class="dropdown-menu" role="menu" >');
        var addGrid = $('<li><a tabindex="-1" href="#">Insert column here</a></li>');
        
        

        addGrid.click(function(){
            self.createGridSelector();
            return false;
        });

        self.contextmenuUlElement.append(addGrid);

        if(isColumn) {
            self.lastcontextmenuColumn = htmlColumn;
            self.contextMenuColumn(self.contextmenuUlElement);
            self.makeActiveColumn(htmlColumn);
        }

        $('body').append(self.contextmenuUlElement);

        self.contextmenuUlElement.css({
            position: "absolute",
            display: "block",
            left: self.getMenuPosition(self.contextmenuUlElement, event.clientX, 'width', 'scrollLeft'),
            top: self.getMenuPosition(self.contextmenuUlElement, event.clientY, 'height', 'scrollTop')
        });

        $('body').click(function() {
            self.closeContextMenu();
        });

    };

    this.closeContextMenu = function() {
        var self = this;

        self.contextmenuUlElement.remove();
        self.contextMenuIsOpen = false;

        if (self.lastcontextmenuColumn) {
            self.makeDeactivateColumn(self.lastcontextmenuColumn);
        }
    };

    this.contextMenuColumn = function(ul) {
        var self = this;
        var addModule = $('<li><a tabindex="-1" href="#">Insert module</a></li>');
        var changeSize = $('<li><a tabindex="-1" href="#">Change size</a></li>');
        var addAttribute = $('<li><a tabindex="-1" href="#">Add attribute</a></li>');
        var deleteColumn = $('<li><a tabindex="-1" class="error" href="#">Delete</a></li>');

        ul.append(addModule);
        ul.append(changeSize);
        ul.append(addAttribute);
        ul.append(deleteColumn);

        deleteColumn.click(function(){
            bootbox.confirm("Are you sure?", function(result) {
                if(result) {
                    var columnIndex = self.lastcontextmenuColumn.attr('data-index');
                    self.removeColumn(self.selectedRowIndex, columnIndex);
                    self.draw();
                }
            });
            self.closeContextMenu();

            return false;
        });

        changeSize.click(function() {
            var columnIndex = self.lastcontextmenuColumn.attr('data-index');
            var column = self.structure[self.selectedRowIndex][columnIndex];

            self.createGridSelector(column.columns, function(newSize){
                column.columns = newSize;
                self.draw();
            });
            self.closeContextMenu();

            return false;
        });

        addAttribute.click(function(){
            var columnIndex = self.lastcontextmenuColumn.attr('data-index');
            var column = self.structure[self.selectedRowIndex][columnIndex];

            self.columnAttributes(column);
            self.closeContextMenu();

            return false;
        });
    };

    this.columnAttributes = function(column) {
        var self = this;
        var attributes = column.attributes || {};

        var titleRow = $('<div class="row form-group">');
        var colAttrName = $('<div class="col-md-5">Name</div>');
        var colAttrValue = $('<div class="col-md-5">Value</div>');
        var colAttrDelete = $('<div class="col-md-2">Delete</div>');

        titleRow.append(colAttrName);
        titleRow.append(colAttrValue);
        titleRow.append(colAttrDelete);

        var conntent = $('<div >');
        var footer = $('<div >');

        conntent.append(titleRow);

        var buttonAddNew = $('<button class="btn btn-primary" >Add new atribute</button>');
        var buttonSave = $('<button class="btn btn-success" >Apply changes</button>');

        for (name in attributes) {
            conntent.append(self.createAttributeRowElement(name, attributes[name]));
        }

        // clear
        attributes = {};

        buttonAddNew.click(function() {
            conntent.append(self.createAttributeRowElement('', ''));
        });

        buttonSave.click(function() {

            var names = [];
            var values = [];

            $('input.names', conntent).each(function() {
                names.push($(this).val());
            });

            $('input.values', conntent).each(function() {
                values.push($(this).val());
            });

            for(i in names) {
               attributes[names[i]] = values[i];
            }

            column['attributes'] = attributes;

            self.draw();
            modal.modal('hide');
            return false;
        });

        footer.append(buttonAddNew);
        footer.append(buttonSave);

        var modal = self.createModal('Add attribute', conntent, footer);
    };

    this.createAttributeRowElement = function(name, value) {
        var inputsRow = $('<div class="row form-group">');
        var inputAttrName = $('<div class="col-md-5">').append('<input type="text" class="names form-control" placeholder="Name" value="'+name+'" />');
        var inputAttrValue = $('<div class="col-md-5">').append('<input type="text" class="values form-control" placeholder="Value" value="'+value+'"/>');
        var inputAttrDelete = $('<div class="col-md-2">').append('<a href="#" class="error" ><i class="fa fa-times-circle error"></i></a></br>');

        inputsRow.append(inputAttrName);
        inputsRow.append(inputAttrValue);
        inputsRow.append(inputAttrDelete);

        $('a', inputAttrDelete).click(function(){
            inputsRow.remove();
            return false;
        });

        return inputsRow;
    };

    this.removeColumn = function(row, column) {
        var self = this;
        var array = self.structure;
        var newStruct = [];

        for (key in array) {
            var columns = array[key];
            newStruct[key] = [];

            for (index in columns) {
                if (key == row && index == column) {
                    continue;
                }

                newStruct[key].push(columns[index]);
            }
        }

        self.structure = newStruct;
    };

    this.makeActiveColumn = function(column) {
        column.css('opacity', 0.7);
    };

    this.makeDeactivateColumn = function(column) {
        column.css('opacity', 1);
    };

    this.createGridSelector = function(current, addCallback){
        var self = this;

        var select = $('<select class="form-control" >');
        var addButton = $('<button class="btn btn-primary">Add</button>');

        var columnsInRow = (current ? +current + self.freeColumnsInCurrentRow() : self.freeColumnsInCurrentRow());

        for (var i = 1; i <= columnsInRow; i++) {

            var li = $('<option value="'+i+'" '+(current == i ? 'selected="selected"' : '') +'>'+i+' columns</li>');
            select.append(li);
        }

        var conntent = $('<div>');
        conntent.append(select);
        conntent.append(addButton);

        var modal = self.createModal('Insert column', conntent, '');

        addButton.click(function(){

            if (typeof(addCallback) == 'function') {
                addCallback(select.val());
            }
            else {
                self.insertColumn(select.val());
            }

            modal.modal('hide');
        });
    };

    this.getMenuPosition = function(menu, mouse, direction, scrollDir) {
        var win = $(window)[direction](),
            scroll = $(window)[scrollDir](),
            menu = menu[direction](),
            position = mouse + scroll;

        // opening menu would pass the side of the page
        if (mouse + menu > win && menu < mouse) 
            position -= menu;

        return position;
    };

    this.createModal = function(title, body, footer) {
        var self = this;
        
        var myModal = $('<div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">');
        var modalDialog = $('<div class="modal-dialog" role="document">');
        var modalContent = $('<div class="modal-content">');
        var modalHeader = $('<div class="modal-header">');
        var closeModalButton = $('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');

        var modalTitle = $('<h4 class="modal-title">'+title+'</h4>');  
        var modalBody =  $('<div class="modal-body">');
        var modalFooter =  $('<div class="modal-footer">');   
     
        modalHeader.append(closeModalButton);
        modalHeader.append(modalTitle);

        modalBody.append(body);
        modalFooter.append(footer);

        modalContent.append(modalHeader);
        modalContent.append(modalBody);
        modalContent.append(modalFooter);
        modalDialog.append(modalContent);
        myModal.append(modalDialog);
     
        $('body').append(myModal);

        myModal.modal('show');
        myModal.on('hidden.bs.modal', function (e) {
          myModal.remove();
        });

        return myModal;
    };

    this.freeColumnsInCurrentRow = function() {
        var self = this;
        var max = 12;
        var inRow = 0;

        if (self.selectedRowIndex == -1 || typeof(self.structure[self.selectedRowIndex]) == 'undefined') {
            return max;
        }

        for (key in self.structure[self.selectedRowIndex]) {
            inRow += +self.structure[self.selectedRowIndex][key]['columns'];
        }

        return max-inRow;
    };

    this.insertColumn = function(columns) {
        var self = this;

        var column = {'columns': columns, 'childrens': []};

        if (self.selectedRowIndex == -1) {
          self.structure.push([column]);  
        }
        else {
            self.structure[self.selectedRowIndex].push(column);   
        }

        self.draw();
    };

    this.draw = function(parent){
        var self = this;
        var insertTo = self.container;
        var array = self.structure;
        // delete old struct
        self.container.html(''); 

        var myJsonString = JSON.stringify(array);

        $('#pageStructJson').val(myJsonString);

        if (parent) {
            insertTo = parent.html;
            array = parent.struct;
        }

        for (key in array) {
            var row = $('<div class="row">');
            var columns = array[key];

            self.rowEvent(row, key);

            for (index in columns) {
                var column = columns[index];
                var htmlColumn = $('<div class="colcol col-md-'+(column.columns)+'" data-index="'+index+'">');

                if(column.childrens.length > 0) {
                    //self.draw({'html': htmlColumn, 'struct': [column.childrens]});
                }

                row.append(htmlColumn);

                htmlColumn.on("contextmenu", function (e) {
                    e.stopPropagation();
                    self.contextMenu(e, true, $(this));
                    return false;
                });

            }
            insertTo.append(row);
        }
    };

    this.rowEvent = function(row, rowIndex){
        var self = this;

        row.mousedown(function(e){
            e.stopPropagation();
            console.log(rowIndex);
            self.selectedRowIndex = rowIndex;
        });

        row.on("contextmenu", function (e) {
            self.contextMenu(e);
            return false;
        });
    };
}
