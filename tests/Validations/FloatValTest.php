<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\FloatVal;

/**
 * Unit tests for FloatVal validation.
 */
class FloatValTest extends TestCase
{
    /**
     * @group FloatVal
     */
    public function testFloatValidationReturnsTrueWhenProvidedAFloatValue()
    {
        $validation = new FloatVal('amount', 123.12);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group FloatVal
     */
    public function testFloatValidationReturnsTrueWhenProvidedANegativeFloatValue()
    {
        $validation = new FloatVal('amount', -123.12);

        $this->assertTrue($validation->validate());
    }

    public function invalidValueDataProvider()
    {
        return [
            [false],
            [true],
            [123],
            ["1"],
            ["0"],
            ["string"],
            [null]
        ];
    }

    /**
     * @dataProvider invalidValueDataProvider
     * @group FloatVal
     */
    public function testFloatValidationReturnsFalseWhenProvidedANonFloatValue($test)
    {
        $validation = new FloatVal('amount', $test);

        $this->assertFalse($validation->validate());
    }
}
