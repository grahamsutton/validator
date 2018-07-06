<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The Numeric Validation Rule
 *
 * This class is responisble for validating that a value is numeric. The
 * field under validation can be a string, but must be castable to a
 * numeric value, so alpha and alphanumeric strings will not pass.
 */
class Numeric extends Validation
{
    /**
     * Determines if the value is valid.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return is_numeric($this->value);
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field must be a numeric value.";
    }
}
