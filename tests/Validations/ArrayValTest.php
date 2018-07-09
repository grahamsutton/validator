<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\ArrayVal;

/**
 * Unit tests for Array test.
 */
class ArrayValTest extends TestCase
{
    /**
     * @group Array
     */
    public function testArrayValidationReturnsTrueWhenNonEmptyArrayValueIsProvided()
    {
        $validation = new ArrayVal('name', ['value1']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Array
     */
    public function testArrayValidationReturnsTrueWhenEmptyArrayValueIsProvided()
    {
        $validation = new ArrayVal('name', []);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Array
     */
    public function testArrayValidationReturnsTrueWhenNonEmptyArrayWithMixedValuesIsProvided()
    {
        $validation = new ArrayVal('name', ['value1', 2, true, 34.2, ['value2']]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Array
     */
    public function testArrayValidationReturnsTrueWhenAssociativeArrayIsProvided()
    {
        $validation = new ArrayVal('name', ['field1' => 'value1', 'field2' => 'value2']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Array
     */
    public function testArrayValidationReturnsFalseWhenIntegerIsProvided()
    {
        $validation = new ArrayVal('name', 23);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Array
     */
    public function testArrayValidationReturnsFalseWhenFloatIsProvided()
    {
        $validation = new ArrayVal('name', 23.1234);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Array
     */
    public function testArrayValidationReturnsFalseWhenBooleanIsProvided()
    {
        $validation = new ArrayVal('name', true);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Array
     */
    public function testArrayValidationReturnsFalseWhenStringIsProvided()
    {
        $validation = new ArrayVal('name', 'string');

        $this->assertFalse($validation->validate());
    }

    /**
     * @group Array
     */
    public function testArrayValidationReturnsFalseWhenNullIsProvided()
    {
        $validation = new ArrayVal('name', null);

        $this->assertFalse($validation->validate());
    }
}
