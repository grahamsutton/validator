<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The Date Validation Rule
 *
 * This class is responisble for validating that a value is a date that can be parsed
 * correctly by PHP's strtotime function.
 */
class Date extends Validation
{
    /**
     * Determines if the value is valid.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return !is_object($this->value) && !is_array($this->value) && strtotime($this->value);
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field is not a valid date.";
    }
}
