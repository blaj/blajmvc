<?php

namespace Blaj\BlajMVC\Core\FormValidation;

class FormRule
{

    /**
     * @var String
     */
    private $value;

    /**
     * @var String
     */
    private $displayname;

    /**
     * @var String
     */
    private $rules;

    public function __construct($value, $displayname, $rules)
    {
        $this->value = $value;
        $this->displayname = $displayname;
        $this->rules = $rules;
    }

    /**
     * @return String
     */
    public function getValue(): String
    {
        return $this->value;
    }

    /**
     * @return String
     */
    public function getDisplayname(): String
    {
        return $this->displayname;
    }

    /**
     * @return String
     */
    public function getRules(): String
    {
        return $this->rules;
    }

}
