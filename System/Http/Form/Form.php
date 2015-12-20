<?php

namespace System\Http\Form;

class Form
{
    private $request;
    private $rules = [];
    private $properties = [];
    private $errors = [];
    private $formData = [];
    private $entity;
    private $entityName;

    public function __construct(\System\Http\Request\Request $request)
    {
        $this->request = $request;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
        $this->entityName = explode('\\', get_class($entity));
        $this->entityName = strtolower(end($this->entityName));
        $this->getVars();

        $this->formData = $this->request->post($this->entityName);

        return $this;
    }

    public function valid()
    {
        $noErrors  = true;

        foreach ($this->rules as $property => $rules) {
            foreach($rules as $ruleObject) {
                $value = null;

                if (is_array($this->formData) && array_key_exists($property, $this->formData)) {
                    $value = $this->formData[$property];
                }

                if (!$ruleObject->valid($value, $this->formData)) {

                    if (!isset($this->errors[$property])) {
                        $this->errors[$property] = ['name' => ucfirst($this->transformToNice($property)), 'messages' => []];
                    }

                    $this->errors[$property]['messages'][] = $ruleObject->getMessage();
                    $noErrors = false;
                }
            }
        }

        $this->fillEntity();

        return $noErrors;
    }

    public function addRule($property, $ruleObject)
    {
        $this->rules[$property][] = $ruleObject;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function getVars()
    {
        $reflect = new \ReflectionObject($this->entity);

        foreach ($reflect->getProperties(\ReflectionProperty::IS_PROTECTED) as $property) {
            if ($property->name == 'id') {
                continue;
            }

            $this->properties[] = $property->name;
        }
    }

    private function fillEntity()
    {
        foreach ($this->properties as $property) {

            $value = null;

            if (isset($this->formData[$property])) {
                $value = $this->formData[$property];
            }

            $method = 'set'.ucfirst($property);
            $this->entity->$method($value);
        }
    }

    private function transformToNice($string)
    {
        return strtolower(preg_replace('/\B[A-Z]/', " $0", $string));
    }
}
