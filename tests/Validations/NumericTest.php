<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\Numeric;

/**
 * Unit tests for Numeric validation.
 */
class NumericTest extends TestCase
{
    /**
     * @group Numeric
     */
    public function testNumericValidationReturnsTrueWhenProvidedAnIntValue()
    {
        $validation = new Numeric('name', 35);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Numeric
     */
    public function testNumericValidationReturnsTrueWhenProvidedAnFloatValue()
    {
        $validation = new Numeric('name', 35.4567);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Numeric
     */
    public function testNumericValidationReturnsTrueWhenProvidedAnIntValueAsString()
    {
        $validation = new Numeric('name', "47");

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Numeric
     */
    public function testNumericValidationReturnsTrueWhenProvidedAnFloatValueAsString()
    {
        $validation = new Numeric('name', "47.1234");

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Numeric
     */
    public function testNumericValidationReturnsFalseWhenProvidedANonNumericString()
    {
        $validation = new Numeric('name', 'something');

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Numeric
     */
    public function testNumericValidationReturnsFalseWhenProvidedAnAlphaNumericString()
    {
        $validation = new Numeric('name', 'something123');

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Numeric
     */
    public function testNumericValidationReturnsFalseWhenProvidedABool()
    {
        $validation = new Numeric('name', true);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Numeric
     */
    public function testNumericValidationReturnsFalseWhenProvidedAnArray()
    {
        $validation = new Numeric('name', ['123']);

        $this->assertFalse($validation->validate());
    }
}
