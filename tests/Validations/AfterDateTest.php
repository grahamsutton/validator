<?php

namespace Validator\Tests;

use PHPUnit\Framework\TestCase;
use Validator\Validations\AfterDate;

/**
 * Unit tests for AfterDate validation.
 */
class AfterDateTest extends TestCase
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
     * @group AfterDate
     */
    public function testAfterDateValidationReturnsTrueWhenProvidedADateAfterTheDefinedDate($test)
    {
        $validation = new AfterDate('end_date', $test, ['1960-01-01']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @dataProvider dateDataProvider
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsTrueWithValidStringToTimeValuesForDefinedDate($test)
    {
        $validation = new AfterDate('end_date', '3000-01-01 01:00:00', [$test]);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsTrueWithOneSecondTimeDifference()
    {
        $validation = new AfterDate('end_date', '2018-01-01 01:00:02', ['2018-01-01 01:00:01']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsFalseWithOneSecondTimeDifference()
    {
        $validation = new AfterDate('end_date', '2018-01-01 01:00:00', ['2018-01-01 01:00:01']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsFalseWithExactTimeToTheSecond()
    {
        $validation = new AfterDate('end_date', '2018-01-01 01:00:01', ['2018-01-01 01:00:01']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsTrueWithOneMinuteTimeDifference()
    {
        $validation = new AfterDate('end_date', '2018-01-01 01:02:00', ['2018-01-01 01:01:00']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsFalseWithOneMinuteTimeDifference()
    {
        $validation = new AfterDate('end_date', '2018-01-01 01:00:00', ['2018-01-01 01:01:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsFalseWithExactTimeToTheMinute()
    {
        $validation = new AfterDate('end_date', '2018-01-01 01:01:00', ['2018-01-01 01:01:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsTrueWithOneHourTimeDifference()
    {
        $validation = new AfterDate('end_date', '2018-01-01 02:00:00', ['2018-01-01 01:00:00']);

        $this->assertTrue($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsFalseWithOneHourTimeDifference()
    {
        $validation = new AfterDate('end_date', '2018-01-01 01:00:00', ['2018-01-01 02:00:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationsReturnsFalseWithExactTimeToTheHour()
    {
        $validation = new AfterDate('end_date', '2018-01-01 01:00:00', ['2018-01-01 01:00:00']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationReturnsFalseWhenProvidedADateBeforeTheDefinedDate()
    {
        $validation = new AfterDate('end_date', '2018-01-01', ['2018-01-02']);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationReturnsFalseWhenProvidedADateThatIsOnTheDefinedDate()
    {
        $validation = new AfterDate('end_date', '2018-01-01', ['2018-01-01']);

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
     * @group AfterDate
     */
    public function testAfterDateValidationReturnsFalseWhenProvidedAnInvalidDefinedDate($test)
    {
        $validation = new AfterDate('end_date', '2018-01-01', [$test]);

        $this->assertFalse($validation->validate());
    }

    /**
     * @group AfterDate
     */
    public function testAfterDateValidationReturnsAppropriateErrorMessage()
    {
        $validation = new AfterDate('end_date', '2017-01-01', ['2018-01-01']);
        $validation->validate();

        $this->assertEquals(
            'The end_date field value must be after 2018-01-01 00:01:00 (yyyy-mm-dd hh:mm:ss).', 
            $validation->getMessage()
        );
    }
}
