<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The Boolean Validation Rule
 *
 * This class is responisble for validating that a value is a boolean. The
 * field under validation must be able to cast to bool.
 */
class Boolean extends Validation
{
    /**
     * Determines if the value is valid.
     *
     * @return bool
     */
    public function validate(): bool
    {
        if (is_array($this->value) || is_float($this->value)) {
            return false;
        }

        if (is_bool($this->value)) {
            return true;
        }

        if (is_int($this->value)) {
            return in_array($this->value, [0, 1]);
        }

        return in_array($this->value, ["0", "1"]);
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field must be a boolean value.";
    }
}
