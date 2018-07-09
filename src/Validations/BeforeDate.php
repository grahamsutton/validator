<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The Before Date Validation Rule
 *
 * This class is responisble for validating that a value is a date that can be parsed
 * correctly by PHP's strtotime function and is before the user-specified date provided.
 */
class BeforeDate extends Validation
{
    /**
     * The date the value being validated must come before.
     *
     * @var DateTime
     */
    protected $before_date;

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

        $this->before_date = $params[0];
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

        if (is_object($this->before_date) || is_array($this->before_date)) {
            return false;
        }

        $value       = strtotime($this->value);
        $before_date = strtotime($this->before_date);

        if (!$before_date || !$value) {
            return false;
        }

        // Check if it comes before
        return $value < $before_date;
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        $before_date = date("Y-m-d H:m:s", strtotime($this->before_date));

        return "The $this->name field value must be before $before_date (yyyy-mm-dd hh:mm:ss).";
    }
}
