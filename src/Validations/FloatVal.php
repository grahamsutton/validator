<?php

namespace Validator\Validations;

use Validator\Validation;

/**
 * The FloatVal Validation Rule
 *
 * This class is responsible for validating that a value is an float.
 */
class FloatVal extends Validation
{
    /**
     * Determines if the value is valid.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return is_float($this->value);
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field must be a float.";
    }
}
