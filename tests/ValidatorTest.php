<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validator;

/**
 * Unit tests for Validator\Validator
 */
class ValidatorTest extends TestCase
{
    /**
     * @group Validator
     */
    public function testRequiredMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->required('name', 'something');

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testValidationMethodsCanBeChained()
    {
        $validator = new Validator();

        $validator
            ->required('name', 'something')
            ->required('age', 27);

        $this->assertTrue($validator->validate());
    }

    /**
     * @expectedException \Validator\Exceptions\ValidationNotFoundException
     * @group Validator
     */
    public function testExceptionIsThrownWhenUnregisteredValidationIsCalled()
    {
        $validator = new Validator();
        $validator->asjkdfasjdhf('name', 'something', 20);
    }
}
