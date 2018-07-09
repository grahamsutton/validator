<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\Date;

/**
 * Unit tests for Date validation.
 */
class DateTest extends TestCase
{
    public function dateDataProvider()
    {
        return [
            ['now'],
            ['10 September 2000'],
            ['+1 day'],
            ['+1 week'],
            ['+1 week 2 days 4 hours 2 seconds'],
            ['next Thursday'],
            ['last Monday'],
            ['2018-04-23'],
            ['2018-04-23 3:30:00'],
            ['04/23/2018'],
            ['04/23/2018 4:30:00'],
        ];
    }

    /**
     * @dataProvider dateDataProvider
     * @group Date
     */
    public function testDateValidationReturnsTrueWhenProvidedAValidDate($test)
    {
        $validation = new Date('date', $test);

        $this->assertTrue($validation->validate());
    }

    public function invalidDateDataProvider()
    {
        $date = new \DateTime();

        return [
            [false],
            [true],
            ['wrong'],
            [123.45],
            [['value1', 'value2']],
            [123],
            [null],
            [$date]
        ];
    }

    /**
     * @dataProvider invalidDateDataProvider
     * @group Date
     */
    public function testDateValidationReturnsFalseWhenProvidedAnInvalidDate($test)
    {
        $validation = new Date('date', $test);

        $this->assertFalse($validation->validate());
    }
}
