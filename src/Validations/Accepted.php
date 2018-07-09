<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The Accepted Validation Rule
 *
 * This class is responisble for validating that a value is truthy, either by
 * native true, 1, "yes", or "1". This is good for determining that a value
 * must be true for things like accepting terms and conditions.
 */
class Accepted extends Validation
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

        if (is_bool($this->value) && $this->value) {
            return true;
        }

        if (is_int($this->value)) {
            return $this->value === 1;
        }

        return $this->value === "1" || strtolower($this->value) === "yes";
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field must be accepted.";
    }
}
