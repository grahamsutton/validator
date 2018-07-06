<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\Boolean;

/**
 * Unit tests for Boolean validation.
 */
class BooleanTest extends TestCase
{
    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsTrueWhenProvidedATrueBoolValue()
    {
        $validation = new Boolean('name', true);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsTrueWhenProvidedAFalseBoolValue()
    {
        $validation = new Boolean('name', false);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsTrueWhenProvidedAOneAsAStringValue()
    {
        $validation = new Boolean('name', "1");

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsTrueWhenProvidedAZeroAsAStringValue()
    {
        $validation = new Boolean('name', "0");

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsTrueWhenProvidedAOneAsAnIntValue()
    {
        $validation = new Boolean('name', 1);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsTrueWhenProvidedAZeroAsAnIntValue()
    {
        $validation = new Boolean('name', 0);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsFalseWhenProvidedANonBinaryStringValue()
    {
        $validation = new Boolean('name', "2");

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsFalseWhenProvidedANormalStringValue()
    {
        $validation = new Boolean('name', "something");

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsFalseWhenProvidedAnArray()
    {
        $validation = new Boolean('name', ['value1']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsFalseWhenProvidedAZeroAsAFloat()
    {
        $validation = new Boolean('name', 0.0);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Boolean
     */
    public function testBooleanValidationReturnsFalseWhenProvidedAOneAsAFloat()
    {
        $validation = new Boolean('name', 1.0);

        $this->assertFalse($validation->validate());
    }
}
