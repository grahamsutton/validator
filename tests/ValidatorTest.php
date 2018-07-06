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
    public function testMaxMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->max('name', 'something', 20);

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testMinMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->min('name', 'something', 5);

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testBooleanMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->boolean('name', true);

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testEmailMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->email('name', 'someone@example.com');

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testNumericMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->numeric('name', 25);

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testDateMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->date('date', '2018-01-01 03:30:00');

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

    /**
     * @group Validator
     */
    public function testRulePipingCorrectlyValidatesASeriesOfConditions()
    {
        $validator = new Validator([
            'name'       => 'required|min:3|max:15',
            'age'        => 'required|numeric',
            'email'      => 'required|email',
            'accepted'   => 'required|boolean',
            'date'       => 'required|date'
        ]);

        $this->assertTrue($validator->validate([
            'name'       => 'someone',
            'age'        => 23,
            'email'      => 'someone@example.com',
            'accepted'   => true,
            'date'       => '2018-02-18 23:00:00'
        ]));
    }

    /**
     * @group Validator
     */
    public function testRequiredValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'name' => 'required'
        ]);

        $this->assertTrue($validator->validate([
            'name' => 'someone',
        ]));
    }

    /**
     * @group Validator
     */
    public function testRequiredValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'required',
        ]);

        $this->assertFalse($validator->validate([
            'name' => ''
        ]));
    }

    /**
     * @group Validator
     */
    public function testValidatorReturnsTrueWhenFieldIsNotRequired()
    {
        $validator = new Validator([
            'name' => 'max:10'
        ]);

        $this->assertTrue($validator->validate([
            'name' => null
        ]));
    }

    /**
     * @group Validator
     */
    public function testMinLengthValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'name' => 'min:3',
        ]);

        $this->assertTrue($validator->validate([
            'name' => 'something'
        ]));
    }

    /**
     * @group Validator
     */
    public function testMinLengthValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'min:3',
        ]);

        $this->assertFalse($validator->validate([
            'name' => 's'
        ]));
    }

    /**
     * @group Validator
     */
    public function testMaxLengthValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'name' => 'max:10',
        ]);

        $this->assertTrue($validator->validate([
            'name' => 'something'
        ]));
    }

    /**
     * @group Validator
     */
    public function testMaxLengthValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'max:3',
        ]);

        $this->assertFalse($validator->validate([
            'name' => 'something'
        ]));
    }

    /**
     * @group Validator
     */
    public function testEmailValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'name' => 'email',
        ]);

        $this->assertTrue($validator->validate([
            'name' => 'someone@example.com'
        ]));
    }

    /**
     * @group Validator
     */
    public function testEmailValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'email',
        ]);

        $this->assertFalse($validator->validate([
            'name' => 'someoneexample.com'
        ]));
    }

    /**
     * @group Validator
     */
    public function testNumericValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'name' => 'numeric',
        ]);

        $this->assertTrue($validator->validate([
            'name' => 123
        ]));
    }

    /**
     * @group Validator
     */
    public function testNumericValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'numeric',
        ]);

        $this->assertFalse($validator->validate([
            'name' => 'something'
        ]));
    }

    /**
     * @group Validator
     */
    public function testBooleanValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'name' => 'boolean',
        ]);

        $this->assertTrue($validator->validate([
            'name' => true
        ]));
    }

    /**
     * @group Validator
     */
    public function testBooleanValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'boolean',
        ]);

        $this->assertFalse($validator->validate([
            'name' => 'something'
        ]));
    }

    /**
     * @group Validator
     */
    public function testDateValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'name' => 'date',
        ]);

        $this->assertTrue($validator->validate([
            'name' => '2018-02-18 03:30:00'
        ]));
    }

    /**
     * @group Validator
     */
    public function testDateValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'date',
        ]);

        $this->assertFalse($validator->validate([
            'name' => 'something'
        ]));
    }
}
