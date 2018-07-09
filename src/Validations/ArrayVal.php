<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The Array Validation Rule
 *
 * This class is responisble for validating that a value provided is an array.
 */
class ArrayVal extends Validation
{
    /**
     * Determines if the value is valid.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return is_array($this->value);
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field must be an array.";
    }
}
