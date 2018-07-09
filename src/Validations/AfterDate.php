<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The After Date Validation Rule
 *
 * This class is responisble for validating that a value is a date that can be parsed
 * correctly by PHP's strtotime function and is after the user-specified date provided.
 */
class AfterDate extends Validation
{
    /**
     * The date the value being validated must come before.
     *
     * @var DateTime
     */
    protected $after_date;

    /**
     * Constructor
     *
     * @param string $name
     * @param mixed  $value
     * @param array  $params
     */
    public function __construct(string $name, $value, array $params = [])
    {
        parent::__construct($name, $value);

        $this->after_date = $params[0];
    }

    /**
     * Determines if the value is valid.
     *
     * @return bool
     */
    public function validate(): bool
    {
        if (is_object($this->value) || is_array($this->value)) {
            return false;
        }

        if (is_object($this->after_date) || is_array($this->after_date)) {
            return false;
        }

        $value      = strtotime($this->value);
        $after_date = strtotime($this->after_date);

        if (!$after_date || !$value) {
            return false;
        }

        // Check if it comes after
        return $value > $after_date;
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        $after_date = date("Y-m-d H:m:s", strtotime($this->after_date));

        return "The $this->name field value must be after $after_date (yyyy-mm-dd hh:mm:ss).";
    }
}
