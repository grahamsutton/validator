<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\MinLength;

/**
 * Unit tests for MinLength test.
 */
class MinLengthTest extends TestCase
{
    /**
     * @group MinLength
     */
    public function testMinLengthValidationReturnsTrueWhenStringValueIsGreaterThanMinLength()
    {
        $validation = new MinLength('name', 'something', [4]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group MinLength
     */
    public function testMinLengthValidationReturnsTrueWhenStringValueEqualsMinLength()
    {
        $validation = new MinLength('name', 'something', [9]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group MinLength
     */
    public function testMinLengthValidationReturnsFalseWhenStringValueIsLessThanMinLength()
    {
        $validation = new MinLength('name', 'something', [15]);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group MinLength
     */
    public function testMinLengthValidationReturnsTrueWhenIntValueIsGreaterThanMinLength()
    {
        $validation = new MinLength('name', 21, [20]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group MinLength
     */
    public function testMinLengthValidationReturnsTrueWhenIntValueEqualsMinLength()
    {
        $validation = new MinLength('name', 20, [20]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group MinLength
     */
    public function testMinLengthValidationReturnsFalseWhenIntValueIsLessThanMinLength()
    {
        $validation = new MinLength('name', 19, [20]);

        $this->assertFalse($validation->validate());
    }

    /**
     * @expectedException \Validator\Exceptions\InvalidArgumentException
     * @group MinLength
     */
    public function testMinLengthValidationThrowsExceptionWhenArrayValueIsProvided()
    {
        $validation = new MinLength('name', ['value1'], [20]);

        $validation->validate();
    }

    /**
     * @expectedException \Validator\Exceptions\InvalidArgumentException
     * @group MinLength
     */
    public function testMinLengthValidationThrowsExceptionWhenBoolValueIsProvided()
    {
        $validation = new MinLength('name', true, [20]);

        $validation->validate();
    }

    /**
     * @group MinLength
     */
    public function testMinLengthValidationReturnsAppropriateErrorMessage()
    {
        $validation = new MinLength('name', 'something', [20]);

        $this->assertEquals(
            'The name field must be greater than or equal to 20 characters.',
            $validation->getMessage()
        );
    }
}
