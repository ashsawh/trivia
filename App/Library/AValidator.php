<?php

namespace App\Library;

use App\Library\Contracts\IValidator;

use Respect\Validation\Exceptions\ValidationException;

abstract class AValidator implements IValidator {
    protected $messages = array();
    protected $inputs = array();
    protected static $abstract = array(
        'getMessages', 'run', 'getValidators'
    );

    function __construct(array $input = array())
    {
        $this->inputs = $input;
    }

    function setInput(array $inputs)
    {
        $this->inputs = $inputs;
        return $this;
    }

    public function run()
    {
        try {
            $validators = $this->getValidators();
            foreach ($this->inputs as $name => $value) {
                if (in_array($name, $validators)) {
                   $this->$name($value);
                }
            }
        } catch (ValidationException $e) {
            $this->messages = $e->getMessages();
        }
        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    protected function getValidators()
    {
        return array_diff(get_class_methods($this), get_class_methods(__CLASS__));
    }
}
