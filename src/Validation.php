<?php

namespace Validator;

/**
 * The Validation Class
 *
 * This class is responsible for common functionality across
 * all inheriting validation subclasses.
 */
abstract class Validation
{
    /**
     * The name of the value so that it can be identified.
     *
     * @var string
     */
    protected $name;

    /**
     * The value being analyzed.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Constructor
     *
     * @param string $name
     * @param mixed  $value
     */
    public function __construct(string $name, $value)
    {
        $this->setName($name);
        $this->value = $value;
    }

    /**
     * Validates and ensures the name of the field is correctly
     * set.
     *
     * @param string $name
     *
     * @return void
     *
     * @throws System_InvalidArgumentException
     */
    private function setName(string $name)
    {
        if (empty($name)) {
            throw new System_InvalidArgumentException(
                'Invalid field name provided.'
            );
        }

        $this->name = $name;
    }

    /**
     * Returns the name of the validation.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Asserts a validation defined by the subclass.
     *
     * @return bool
     */
    abstract public function validate(): bool;

    /**
     * Returns the error message when the validation fails.
     *
     * @return string
     */
    abstract public function getMessage(): string;
}