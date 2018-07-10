<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The Integer Validation Rule
 *
 * This class is responsible for validating that a value is an integer.
 */
class Integer extends Validation
{
    /**
     * Determines if the value is valid.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return is_int($this->value);
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field must be an integer.";
    }
}
