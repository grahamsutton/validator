<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\MaxLength;

/**
 * Unit tests for MaxLength validation.
 */
class MaxLengthTest extends TestCase
{
    /**
     * @group MaxLength
     */
    public function testMaxLengthValidationReturnsTrueWhenStringValueIsLessThanMaxLength()
    {
        $validation = new MaxLength('name', 'something', [20]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group MaxLength
     */
    public function testMaxLengthValidationReturnsTrueWhenStringValueEqualsMaxLength()
    {
        $validation = new MaxLength('name', 'something', [9]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group MaxLength
     */
    public function testMaxLengthValidationReturnsFalseWhenStringValueIsGreaterThanMaxLength()
    {
        $validation = new MaxLength('name', 'something', [5]);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group MaxLength
     */
    public function testMaxLengthValidationReturnsTrueWhenIntValueIsLessThanMaxLength()
    {
        $validation = new MaxLength('name', 19, [20]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group MaxLength
     */
    public function testMaxLengthValidationReturnsTrueWhenIntValueEqualsMaxLength()
    {
        $validation = new MaxLength('name', 20, [20]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group MaxLength
     */
    public function testMaxLengthValidationReturnsFalseWhenIntValueIsGreaterThanMaxLength()
    {
        $validation = new MaxLength('name', 21, [20]);

        $this->assertFalse($validation->validate());
    }

    /**
     * @expectedException \Validator\Exceptions\InvalidArgumentException
     * @group MaxLength
     */
    public function testMaxLengthValidationThrowsExceptionWhenArrayValueIsProvided()
    {
        $validation = new MaxLength('name', ['value1'], [20]);

        $validation->validate();
    }

    /**
     * @expectedException \Validator\Exceptions\InvalidArgumentException
     * @group MaxLength
     */
    public function testMaxLengthValidationThrowsExceptionWhenBoolValueIsProvided()
    {
        $validation = new MaxLength('name', true, [20]);

        $validation->validate();
    }

    /**
     * @group MaxLength
     */
    public function testMaxLengthValidationReturnsAppropriateErrorMessage()
    {
        $validation = new MaxLength('name', 'something', [20]);

        $this->assertEquals(
            'The name field must be less than or equal to 20 characters.',
            $validation->getMessage()
        );
    }
}