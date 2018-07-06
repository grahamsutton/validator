<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\Required;

/**
 * Unit tests for Required validation.
 */
class RequiredTest extends TestCase
{
    /**
     * @group Required
     */
    public function testRequiredValidationReturnsTrueWhenProvidedANonEmptyString()
    {
        $validation = new Required('name', 'something');

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsTrueWhenProvidedAnInteger()
    {
        $validation = new Required('name', 31);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsTrueWhenProvidedAFloat()
    {
        $validation = new Required('name', 31.2345);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsTrueWhenProvidedAWhitespace()
    {
        $validation = new Required('name', ' ');

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsTrueWhenProvidedABooleanTrue()
    {
        $validation = new Required('name', true);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsTrueWhenProvidedABooleanFalse()
    {
        $validation = new Required('name', false);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsTrueWhenProvidedANonEmptyArray()
    {
        $validation = new Required('name', ['value1', 'value2']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsTrueWhenProvidedAZero()
    {
        $validation = new Required('name', 0);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsFalseWhenProvidedEmptyString()
    {
        $validation = new Required('name', '');

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsFalseWhenProvidedNull()
    {
        $validation = new Required('name', null);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationReturnsFalseWhenProvidedEmptyArray()
    {
        $validation = new Required('name', []);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Required
     */
    public function testRequiredValidationMessageIsAppropriate()
    {
        $validation = new Required('name', '');

        $this->assertEquals('The name field is required.', $validation->getMessage());
    }
}