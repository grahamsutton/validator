<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\Accepted;

/**
 * Unit tests for Accepted validation.
 */
class AcceptedTest extends TestCase
{
    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsTrueWhenProvidedATrueBoolValue()
    {
        $validation = new Accepted('name', true);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedAFalseBoolValue()
    {
        $validation = new Accepted('name', false);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsTrueWhenProvidedAOneAsAStringValue()
    {
        $validation = new Accepted('name', "1");

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedAZeroAsAStringValue()
    {
        $validation = new Accepted('name', "0");

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsTrueWhenProvidedAOneAsAnIntValue()
    {
        $validation = new Accepted('name', 1);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedAZeroAsAnIntValue()
    {
        $validation = new Accepted('name', 0);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedANonBinaryStringValue()
    {
        $validation = new Accepted('name', "2");

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedANormalStringValue()
    {
        $validation = new Accepted('name', "something");

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedAnArray()
    {
        $validation = new Accepted('name', ['value1']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedAZeroAsAFloat()
    {
        $validation = new Accepted('name', 0.0);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedAOneAsAFloat()
    {
        $validation = new Accepted('name', 1.0);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsTrueWhenProvidedYesAsALowerCaseStringValue()
    {
        $validation = new Accepted('name', "yes");

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsTrueWhenProvidedYesAsAnUpperCaseStringValue()
    {
        $validation = new Accepted('name', "YES");

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Accepted
     */
    public function testAcceptedValidationReturnsFalseWhenProvidedNoAsAStringValue()
    {
        $validation = new Accepted('name', "no");

        $this->assertFalse($validation->validate());
    }
}
