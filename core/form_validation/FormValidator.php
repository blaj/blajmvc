<?php

namespace Blaj\BlajMVC\Core\FormValidation;

class FormValidator
{

    private $rules;

    private $errors;

    public function __construct()
    {
    }

    public function run()
    {
        foreach ($this->rules as $rule) {
            $this->validate($rule);
        }

        return false;
    }

    public function addRule($value, $displayname, $rules)
    {
        $this->rules[] = new FormRule($value, $displayname, $rules);
    }

    private function validate($rule) {
        $rules_list = $rule->getRules();
        $rules_list = explode('|', $rules_list);

        foreach ($rules_list as $rule) {
            $rule = explode(':', $rule);

            switch ($rule[0]) {
                case 'required':
                    if (empty($rule->getValue()))
                        $this->errors[$rule];
                    break;
                case 'min_length':
                    echo 'min_length ' . $rule[1] . '<br>';
                    break;
                case 'max_length':
                    echo 'max_length ' . $rule[1] . '<br>';
                    break;
            }
        }
    }

    public function getErrorMessages()
    {
    }
}
