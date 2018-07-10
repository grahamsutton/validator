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
    public function testArrayMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->array('array', ['value1', 'value2']);

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testAcceptedMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->accepted('accepted', true);

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testBeforeDateMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->beforeDate('start_date', '2018-01-01', '3000-01-01');

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testAfterDateMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->afterDate('end_date', '3000-01-01', '2018-01-01');

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testIntegerMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->int('amount', 123);

        $this->assertTrue($validator->validate());
    }

    /**
     * @group Validator
     */
    public function testFloatMethodCanBeCalledCorrectly()
    {
        $validator = new Validator();
        $validator->float('amount', 123.45);

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
            'boolean'    => 'required|boolean',
            'total'      => 'required|int',
            'amount'     => 'required|float',
            'date'       => 'required|date',
            'checkboxes' => 'required|array',
            'accepted'   => 'required|accepted',
            'before'     => 'required|beforeDate:2018-01-02',
            'after'      => 'required|afterDate:2018-01-01',
        ]);

        $this->assertTrue($validator->validate([
            'name'       => 'someone',
            'age'        => 23,
            'email'      => 'someone@example.com',
            'boolean'    => false,
            'total'      => 345,
            'amount'     => 345.56,
            'date'       => '2018-02-18 23:00:00',
            'checkboxes' => ['value1', 'value2'],
            'accepted'   => true,
            'before'     => '2018-01-01',
            'after'      => '2018-01-02',
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

    /**
     * @group Validator
     */
    public function testArrayValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'name' => 'array',
        ]);

        $this->assertTrue($validator->validate([
            'name' => ['value1', 'value2']
        ]));
    }

    /**
     * @group Validator
     */
    public function testArrayValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'array',
        ]);

        $this->assertFalse($validator->validate([
            'name' => 123
        ]));
    }

    /**
     * @group Validator
     */
    public function testValidationPipeReturnsFalseWhenArrayFieldIsRequiredButIsEmpty()
    {
        $validator = new Validator([
            'name' => 'required|array',
        ]);

        $this->assertFalse($validator->validate([
            'name' => []
        ]));

        $error_messages = $validator->getAllErrors();

        $this->assertCount(1, $error_messages['name']);
        $this->assertEquals('The name field is required.', $error_messages['name'][0]);
    }

    /**
     * @group Validator
     */
    public function testAcceptedValidationPipeReturnsTrueWhenFieldIsTrue()
    {
        $validator = new Validator([
            'name' => 'accepted',
        ]);

        $this->assertTrue($validator->validate([
            'name' => true
        ]));
    }

    /**
     * @group Validator
     */
    public function testAcceptedValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'name' => 'accepted',
        ]);

        $this->assertFalse($validator->validate([
            'name' => 123
        ]));
    }

    /**
     * @group Validator
     */
    public function testBeforeDateValidationPipeReturnsTrueWhenFieldIsTrue()
    {
        $validator = new Validator([
            'date' => 'beforeDate:2018-01-02',
        ]);

        $this->assertTrue($validator->validate([
            'date' => '2018-01-01'
        ]));
    }

    /**
     * @group Validator
     */
    public function testBeforeDateValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'date' => 'beforeDate:2018-01-01',
        ]);

        $this->assertFalse($validator->validate([
            'date' => '2018-01-02'
        ]));
    }

    /**
     * @group Validator
     */
    public function testAfterDateValidationPipeReturnsTrueWhenFieldIsTrue()
    {
        $validator = new Validator([
            'date' => 'afterDate:2018-01-01',
        ]);

        $this->assertTrue($validator->validate([
            'date' => '2018-01-02'
        ]));
    }

    /**
     * @group Validator
     */
    public function testAfterDateValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'date' => 'afterDate:2018-01-02',
        ]);

        $this->assertFalse($validator->validate([
            'date' => '2018-01-01'
        ]));
    }

    /**
     * @group Validator
     */
    public function testIntegerValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'amount' => 'int',
        ]);

        $this->assertTrue($validator->validate([
            'amount' => 345
        ]));
    }

    /**
     * @group Validator
     */
    public function testIntegerValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'amount' => 'int',
        ]);

        $this->assertFalse($validator->validate([
            'amount' => 'incorrect'
        ]));
    }

    /**
     * @group Validator
     */
    public function testFloatValidationPipeReturnsTrueWhenFieldIsValid()
    {
        $validator = new Validator([
            'amount' => 'float',
        ]);

        $this->assertTrue($validator->validate([
            'amount' => 345.56
        ]));
    }

    /**
     * @group Validator
     */
    public function testFloatValidationPipeReturnsFalseWhenFieldIsInvalid()
    {
        $validator = new Validator([
            'amount' => 'float',
        ]);

        $this->assertFalse($validator->validate([
            'amount' => 'incorrect'
        ]));
    }
}
