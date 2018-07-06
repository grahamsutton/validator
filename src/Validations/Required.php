<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The Required Validation Rule
 *
 * This class is responsible for validating that a value is present.
 */
class Required extends Validation
{
    /**
     * Determines if the value is valid.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return is_bool($this->value) || is_int($this->value) || !empty($this->value);
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field is required.";
    }
}
