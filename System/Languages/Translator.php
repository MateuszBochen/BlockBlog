<?php

namespace System\Languages;

class Translator
{
    //TODO
    public function t($sdef)
    {
        return ucfirst(str_replace('_', ' ', $sdef));
    }

}