<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\Integer;

/**
 * Unit tests for Integer validation.
 */
class IntegerTest extends TestCase
{
    /**
     * @group Integer
     */
    public function testIntegerValidationReturnsTrueWhenProvidedAnIntegerValue()
    {
        $validation = new Integer('amount', 12);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group Integer
     */
    public function testIntegerValidationReturnsTrueWhenProvidedANegativeIntegerValue()
    {
        $validation = new Integer('amount', -12);

        $this->assertTrue($validation->validate());
    }

    public function invalidValueDataProvider()
    {
        return [
            [false],
            [true],
            [123.45],
            ["1"],
            ["0"],
            ["string"],
            [null]
        ];
    }

    /**
     * @dataProvider invalidValueDataProvider
     * @group Integer
     */
    public function testIntegerValidationReturnsFalseWhenProvidedANonIntegerValue($test)
    {
        $validation = new Integer('amount', $test);

        $this->assertFalse($validation->validate());
    }
}
