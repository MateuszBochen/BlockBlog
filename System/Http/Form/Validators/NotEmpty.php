<?php

namespace System\Http\Form\Validators;

class NotEmpty
{
    private $message = 'This field can\'t be empty';

    public function valid($value, $formData)
    {
        return (bool) !empty($value);
    }

    public function getMessage()
    {
        return $this->message;
    }
}