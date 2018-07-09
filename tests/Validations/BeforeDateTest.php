<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\BeforeDate;

/**
 * Unit tests for BeforeDate validation.
 */
class BeforeDateTest extends TestCase
{
    public function dateDataProvider()
    {
        return [
            ['now'],
            ['10 September 2018'],
            ['+1 day'],
            ['+1 week'],
            ['+1 week 2 days 4 hours 2 seconds'],
            ['next Thursday'],
            ['2018-04-23'],
            ['2018-04-23 3:30:00'],
            ['04/23/2018'],
            ['04/23/2018 4:30:00'],
        ];
    }

    /**
     * @dataProvider dateDataProvider
     * @group BeforeDate
     */
    public function testBeforeDateValidationReturnsTrueWhenProvidedADateBeforeTheDefinedDate($test)
    {
        $validation = new BeforeDate('start_date', $test, ['3025-01-01']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @dataProvider dateDataProvider
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsTrueWithValidStringToTimeValuesForDefinedDate($test)
    {
        $validation = new BeforeDate('start_date', '2000-01-01 01:00:00', [$test]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsTrueWithOneSecondTimeDifference()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 01:00:01', ['2018-01-01 01:00:02']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsFalseWithOneSecondTimeDifference()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 01:00:01', ['2018-01-01 01:00:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsFalseWithExactTimeToTheSecond()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 01:00:01', ['2018-01-01 01:00:01']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsTrueWithOneMinuteTimeDifference()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 01:01:00', ['2018-01-01 01:02:00']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsFalseWithOneMinuteTimeDifference()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 01:01:00', ['2018-01-01 01:00:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsFalseWithExactTimeToTheMinute()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 01:01:00', ['2018-01-01 01:01:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsTrueWithOneHourTimeDifference()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 01:00:00', ['2018-01-01 02:00:00']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsFalseWithOneHourTimeDifference()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 02:00:00', ['2018-01-01 01:00:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationsReturnsFalseWithExactTimeToTheHour()
    {
        $validation = new BeforeDate('start_date', '2018-01-01 01:00:00', ['2018-01-01 01:00:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationReturnsFalseWhenProvidedADateAfterTheDefinedDate()
    {
        $validation = new BeforeDate('start_date', '2018-01-02', ['2018-01-01']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationReturnsFalseWhenProvidedADateThatIsOnTheDefinedDate()
    {
        $validation = new BeforeDate('start_date', '2018-01-01', ['2018-01-01']);

        $this->assertFalse($validation->validate());
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
     * @group BeforeDate
     */
    public function testBeforeDateValidationReturnsFalseWhenProvidedAnInvalidDefinedDate($test)
    {
        $validation = new BeforeDate('start_date', '2018-01-01', [$test]);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group BeforeDate
     */
    public function testBeforeDateValidationReturnsAppropriateErrorMessage()
    {
        $validation = new BeforeDate('start_date', '2018-01-01', ['2017-01-01']);
        $validation->validate();

        $this->assertEquals(
            'The start_date field value must be before 2017-01-01 00:01:00 (yyyy-mm-dd hh:mm:ss).', 
            $validation->getMessage()
        );
    }
}
