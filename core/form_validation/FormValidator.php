<?php

namespace Blaj\BlajMVC\Core\FormValidation;

use PDO;
use PDOException;

class FormValidator
{

    /**
     * @var Array
     */
    private $rules = array();

    /**
     * @var Array
     */
    private $errors = array();

    /**
     * FormValidator constructor.
     * @param null $rules
     */
    public function __construct($rules = null)
    {
        if ($rules)
            foreach ($rules as $rule)
                $this->addRule($rule['value'], $rule['name'], $rule['displayname'], $rule['rules']);
    }

    /**
     * @return bool
     */
    public function run()
    {
        foreach ($this->rules as $rule) {
            $this->validate($rule);
        }

        if (count($this->errors))
            return false;

        return true;
    }

    /**
     * @param $value
     * @param $name
     * @param $displayname
     * @param $rules
     *
     * Function add new rule to array
     */
    public function addRule($value, $name, $displayname, $rules)
    {
        $this->rules[$name] = new FormRule($this->remove_tags($value), $name, $displayname, $rules);
    }

    /**
     * @param $ruleData
     * @return bool
     */
    public function validate($ruleData) {
        $rules_list = $ruleData->getRules();
        $rules_list = explode('|', $rules_list);

        foreach ($rules_list as $rule) {
            $rule = explode(':', $rule);
            switch ($rule[0]) {
                case 'required':
                    if (empty($ruleData->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Pole ' . $ruleData->getDisplayname() . ' nie może być puste.';
                        return;
                    }
                    break;
                case 'min_length':
                    if(!$this->min_length($ruleData->getValue(), $rule[1])) {
                        $this->errors[$ruleData->getName()][] = 'Pole ' . $ruleData->getDisplayname() . ' musi zawierać minimum ' . $rule[1] . ' znaki.';
                        return;
                    }
                    break;
                case 'max_length':
                    if(!$this->max_length($ruleData->getValue(), $rule[1])) {
                        $this->errors[$ruleData->getName()][] = 'Pole ' . $ruleData->getDisplayname() . ' może zawierać ' . $rule[1] . ' znaki.';
                        return;
                    }
                    break;
                case 'email':
                    if(!$this->is_email($ruleData->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' nie jest e-mail\'em.';
                        return;
                    }
                    break;
                case 'int':
                    if(!$this->is_int($ruleData->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' nie jest liczbą.';
                        return;
                    }
                    break;
                case 'float':
                    if(!$this->is_float($ruleData->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' nie jest liczbą zmiennoprzecinkową.';
                        return;
                    }
                    break;
                case 'bool':
                    if(!$this->is_bool($ruleData->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' nie jest typem logicznym.';
                        return;
                    }
                    break;
                case 'alpha':
                    if(!$this->is_alpha($ruleData->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' może zawierać tylko litery.';
                        return;
                    }
                    break;
                case 'alphanum':
                    if(!$this->is_alphanum($ruleData->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' może zawierać tylko litery i cyfry.';
                        return;
                    }
                    break;
                case 'url':
                    if(!$this->is_url($ruleData->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' nie jest adresem URL.';
                        return;
                    }
                    break;
                case 'equal_to':
                    if(!$this->is_equalto($ruleData->getValue(), $this->rules[$rule[1]]->getValue())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' nie jest taka sama jak w polu ' . $this->rules[$rule[1]]->getDisplayname() . '.';
                        return;
                    }
                    break;
                case 'unique':
                    if(!$this->is_unique($ruleData->getValue(), $rule[1], $ruleData->getName())) {
                        $this->errors[$ruleData->getName()][] = 'Wartość w polu ' . $ruleData->getDisplayname() . ' jest już zajęta.';
                        return;
                    }
                    break;
            }
        }
    }

    /**
     * @param $data
     * @param $min
     * @return bool
     */
    public function min_length($data, $min)
    {
        if (strlen($data) >= $min)
            return true;

        return false;
    }

    /**
     * @param $data
     * @param $max
     * @return bool
     */
    public function max_length($data, $max)
    {
        if (strlen($data) <= $max)
            return true;

        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function is_email($data)
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL))
            return true;

        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function is_int($data)
    {
        if (filter_var($data, FILTER_VALIDATE_INT))
            return true;

        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function is_float($data)
    {
        if (filter_var($data, FILTER_VALIDATE_FLOAT))
            return true;

        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function is_bool($data)
    {
        if (filter_var($data, FILTER_VALIDATE_BOOLEAN))
            return true;

        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function is_alpha($data)
    {
        if (filter_var($data, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z]+$/'))))
            return true;

        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function is_alphanum($data)
    {
        if (filter_var($data, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z0-9]+$/'))))
            return true;

        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function is_url($data)
    {
        if (filter_var($data, FILTER_VALIDATE_URL))
            return true;

        return false;
    }

    public function is_equalto($from, $to)
    {
        if ($from == $to)
            return true;

        return false;
    }

    public function is_unique($data, $table, $name)
    {
        try {
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (PDOException $e) {
            die("PDO Error:" . $e->getMessage());
        }

        $query = $db->prepare("SELECT * FROM $table WHERE $name = :value");
        $query->execute(['value' => $data]);
        $items = $query->fetchAll(\PDO::FETCH_ASSOC);
        if (!isset($items[0])) {
            return true;
        }

        return false;
    }

    /**
     * @param $text
     * @return string
     */
    public function remove_tags($text)
    {
        $text = trim(strip_tags($text));

        if (get_magic_quotes_gpc())
            $text = stripslashes($text);

        return $text;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getError($name)
    {
        return $this->errors[$name];
    }

    /**
     * @return Array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function showErrors()
    {
        $html = '<ul>';
        foreach ($this->errors as $error)
            foreach ($error as $err)
            $html .= '<li>'. $err .'</li>';

        $html .= '</ul>';

        return $html;
    }
}
