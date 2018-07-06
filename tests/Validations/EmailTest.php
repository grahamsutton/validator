<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\Email;

/**
 * Unit tests for Email validation.
 */
class EmailTest extends TestCase
{
    /**
     * @group Email
     */
    public function testEmailValidationReturnsTrueWhenProvidedAValidEmail()
    {
        $validation = new Email('email', 'someone@example.com');

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Email
     */
    public function testEmailValidationReturnsTrueWhenProvidedAnEmailWithDotSeparation()
    {
        $validation = new Email('email', 'some.one@example.com');

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Email
     */
    public function testEmailValidationReturnsTrueWhenProvidedAnAlphaNumericEmail()
    {
        $validation = new Email('email', 'someone123@example.com');

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Email
     */
    public function testEmailValidationReturnsTrueWhenProvidedAnAlphaNumericEmailWithDotSeparation()
    {
        $validation = new Email('email', 'some.one123@example.com');

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Email
     */
    public function testEmailValidationReturnsTrueWhenProvidedAnEmailWithMultipleDotSeparationInDomain()
    {
        $validation = new Email('email', 'some.one123@exa.mple.com');

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Email
     */
    public function testEmailValidationReturnsFalseWhenProvidedAnEmailWithoutAtSymbol()
    {
        $validation = new Email('email', 'someoneexample.com');

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Email
     */
    public function testEmailValidationReturnsFalseWhenProvidedAnEmailWithMoreThanOneAtSymbol()
    {
        $validation = new Email('email', 'some@one@example.com');

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Email
     */
    public function testEmailValidationReturnsFalseWhenProvidedAnEmailWithNoLocalName()
    {
        $validation = new Email('email', '@example.com');

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Email
     */
    public function testEmailValidationErrorMessageIsAppropriate()
    {
        $validation = new Email('email', 'incorrect');
        $validation->validate();

        $this->assertEquals('The email field must be a valid email.', $validation->getMessage());
    }
}
