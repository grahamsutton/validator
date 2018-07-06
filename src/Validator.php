<?php

namespace Validator;

/**
 * The Validator Class
 *
 * This is the central class responsible for managing and validating
 * all validations.
 */
class Validator
{
    /**
     * List of validations to be run.
     *
     * @var array
     */
    protected $validations = [];

    /**
     * Flag to determine if all validations have passed.
     * If even one validation is false, this flag should
     * be set to false.
     *
     * @var bool
     */
    protected $valid;

    /**
     * List of predefined validations to be run when provided an
     * array of values.
     *
     * @var array
     */
    protected $rule_map = [];

    /**
     * List of failed validation messages keyed by field.
     *
     * @var array
     */
    protected $error_messages = [];

    /**
     * Constructor
     *
     * Accepts a list of rules to be validated.
     *
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->reset();
        $this->parseRules($rules);
    }

    /**
     * Captures calls to user-defined methods.
     *
     * The name of the method called should be equal to the key in the registry's array. For
     * example, calling $validator->required('name', 'value') should route to the 'required'
     * key in the validator registry.
     *
     * @param string $name
     * @param array  $args
     *
     * @return self
     *
     * @throws \Validator\Exceptions\ValidationNotFoundException
     */
    public function __call($name, $args)
    {
        $validation = $this->getValidation($name);

        $this->validations[] = new $validation($args[0], $args[1], array_slice($args, 2));

        return $this;
    }

    /**
     * Runs the validations and returns whether the validation was successful
     * or not.
     *
     * If a rule map is present, the generateValidations method will instantiate
     * the validation objects for each rule along with the validation 
     *
     * @return bool
     */
    public function validate(array $values = []): bool
    {
        $this->reset();

        if (!empty($values)) {
            $this->generateValidations($values);
        }

        foreach ($this->validations as $validation) {
            $state = $validation->validate();

            $this->valid = $this->valid && $state;

            if (!$state) {
                $this->collectError($validation);
            }
        }

        return $this->valid;
    }

    /**
     * Generates validation objects if a rule map was specified.
     *
     * @param array $values
     *
     * @return void
     */
    protected function generateValidations(array $values)
    {
        foreach ($this->rule_map as $field => $rules) {
            foreach ($rules as $rule) {
                $args = explode(':', $rule);

                $function = $args[0];
                $name     = $field;
                $value    = $values[$field];
                $params   = array_slice($args, 1);

                $validation = $this->getValidation($function);

                $this->validations[] = new $validation($name, $value, $params);
            }
        }
    }

    /**
     * Returns a validation class from the registry. Will throw an exception
     * if it does not exist. The action var is the name of the validation.
     *
     * @param string $action
     *
     * @return string
     *
     * @throws \Validator\Exceptions\ValidationNotFoundException
     */
    protected function getValidation(string $action): string
    {
        if (!in_array($action, array_keys(\Validator\Registry::$validations))) {
            throw new \Validator\Exceptions\ValidationNotFoundException(
                "Validation for '$action' is not registered in the registry."
            );
        }

        return \Validator\Registry::$validations[$action];
    }

    /**
     * Takes a validation and collects the error message on it.
     *
     * @param \Validator\Validation $validation
     *
     * @return void 
     */
    protected function collectError(\Validator\Validation $validation)
    {
        $name = $validation->getName();

        if (!isset($this->error_messages[$name])) {
            $this->error_messages[$name] = [];
        }

        $this->error_messages[$name][] = $validation->getMessage();
    }

    /**
     * Returns a list of error messages keyed by field.
     *
     * @return array
     */
    public function getAllErrors(): array
    {
        return $this->error_messages;
    }

    /**
     * Returns a flat associative array where the key is the field
     * name and the value is the first error message that occurred.
     *
     * This method is meant to be a bit more convenient for parsing
     * and does not return all errors (only the first detected errors).
     *
     * @return array
     */
    public function getErrors(): array
    {
        $error_bag = [];

        foreach ($this->error_messages as $field => $errors) {
            $error_bag[$field] = $errors[0];
        }

        return $error_bag;
    }

    /**
     * Resets the validator to true so that validation rules can be re-run
     * to determine truthiness.
     *
     * @return void
     */
    protected function reset()
    {
        $this->validations = [];
        $this->valid       = true;
    }

    /**
     * Parse the rules provided (if any) and determine which validations to
     * call per field.
     *
     * @return void
     */
    protected function parseRules(array $rules)
    {
        foreach ($rules as $field => $rule_pipe) {
            $this->rule_map[$field] = explode('|', $rule_pipe);
        }
    }
}