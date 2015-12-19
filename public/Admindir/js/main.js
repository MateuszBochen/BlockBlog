

function ToggleEnabled(element) {
    this.element = element;
    this.clickElement;
    this.url = '';
    this.current = 0;
    this.enableIf = "1";

    this.init = function() {
        this.url = this.element.attr('data-url');
        this.current = this.element.attr('data-current');
        var dataEnableIf = this.element.attr('data-enable-if');

        if (dataEnableIf && dataEnableIf != '') {
            this.enableIf = dataEnableIf;
        }

        console.log([this.enableIf, this.current]);
        if (this.enableIf == this.current) {
            this.enabled();
        }
        else {
            this.disabled();
        }

        this.toggle();
    };

    this.enabled = function() {
        this.element.empty();
        this.clickElement = $('<i class="fa fa-toggle-on"></i>');
        this.element.append(this.clickElement);
    };

    this.disabled = function() {
        this.element.empty();
        this.clickElement = $('<i class="fa fa-toggle-off"></i>');
        this.element.append(this.clickElement);
    };

    this.toggle = function() {
        var self = this;

        this.clickElement.click(function() {
            self.current = Math.abs(self.current-1);
            var url = self.url.replace('#current', self.current);

            $.get(url).done(function(){
                if (self.enableIf == self.current) {
                    self.enabled();
                }
                else {
                    self.disabled();
                }

                self.toggle();
            });
        });
    }
}



$(function() {
  
    $('.toggleEnabled').each(function(index, element){
        var jElement = $(element);

        var toggleEnabled = new ToggleEnabled(jElement);
        toggleEnabled.init();
    });

});