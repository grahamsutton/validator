<?php

namespace Validator\Validations;

use Validator\Validation;
use Validator\Exceptions\InvalidArgumentException;

/**
 * The Min Length Validation
 *
 * This class is responsible for validating that a field does not
 * exceed the specified min length.
 */
class MinLength extends Validation
{
    /**
     * The minimum length that the string can be.
     *
     * @var int
     */
    protected $min_length;

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

        $this->min_length = (int) $params[0];
    }

    /**
     * Determines if the value is valid.
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function validate(): bool
    {
        if (is_array($this->value)) {
            throw new InvalidArgumentException(
                "Value provided for min length validation cannot be an array."
            );
        }

        if (is_bool($this->value)) {
            throw new InvalidArgumentException(
                "Value provided for min length validation cannot be a bool."
            );
        }

        if (is_int($this->value) || is_float($this->value)) {
            return $this->value >= $this->min_length;
        }

        $value = (string) $this->value;

        return strlen($value) >= $this->min_length;
    }

    /**
     * Message to return when the validation fails.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return "The $this->name field must be greater than or equal to $this->min_length characters.";
    }
}
