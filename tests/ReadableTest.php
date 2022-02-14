<?php

namespace Pharaonic\Laravel\Readable;

use Orchestra\Testbench\TestCase;


class ReadableTest extends TestCase
{
    public function testNumber()
    {
        $this->assertEquals('10,203,040', Readable::getNumber(10203040));
    }

    public function testNumberToString()
    {
        if (!\extension_loaded('intl'))
            $this->fail('Intl extension has not been loaded.');

        $this->assertEquals('seven thousand seven hundred twenty-one', Readable::getNumberToString(7721));
    }

    public function testHumanNumber()
    {
        $this->assertEquals('77.7K', Readable::getHumanNumber(77700, true, 1));
    }

    public function testDecimal()
    {
        $this->assertEquals('60,708.54', Readable::getDecimal(60708.54));
    }

    public function testDecInt()
    {
        $this->assertEquals(70, Readable::getDecInt(70.0));
    }

    public function testDate()
    {
        $this->assertEquals('24 April 2020', Readable::getDate('24-04-2020'));
    }

    public function testTime()
    {
        $this->assertEquals('03:20 PM', Readable::getTime('15:20:22', true));
    }

    public function testDateTime()
    {
        $this->assertEquals('Friday, April 24, 2020 05:20:30 PM', Readable::getDateTime('24-04-2020 17:20:30', true, true));
    }

    public function testDiffDateTime()
    {
        $this->assertEquals('29 years before', Readable::getDiffDateTime('01-02-1993 19:00:00', '01-02-2022 19:00:00'));
    }

    public function testTimeLength()
    {
        $this->assertEquals('3 months 29 minutes 37 seconds', Readable::getTimeLength(7777777));
    }

    public function testDateTimeLength()
    {
        $this->assertEquals('29 years before', Readable::getDateTimeLength('01-02-1993 19:00:00', '01-02-2022 19:00:00'));
    }

    public function testSize()
    {
        $this->assertEquals('7 KiB', Readable::getSize(1024 * 7, false));
    }
}
