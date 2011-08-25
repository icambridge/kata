<?php


require_once '../dayofweek.php';

class DayOfWeekTest extends PHPUnit_Framework_TestCase
{

    public function testDateWithSlashes()
    {
        $dayOfWeek = kataDayOfWeek("05/05/1985");
        $this->assertEquals("Sunday",$dayOfWeek);
    }

    public function testDateWithDots()
    {
        $dayOfWeek = kataDayOfWeek("04.03.1986");
        $this->assertEquals("Tuesday",$dayOfWeek);
    }

    public function testDateWithSpaces()
    {
        $dayOfWeek = kataDayOfWeek("07 09 1961");
        $this->assertEquals("Thursday",$dayOfWeek);
    }

    public function testDateWithDashes()
    {
        $dayOfWeek = kataDayOfWeek("05-05-1985");
        $this->assertEquals("Sunday",$dayOfWeek);
    }

    public function testDateWithNumbers()
    {
        $dayOfWeek = kataDayOfWeek(15051985);
        $this->assertFalse($dayOfWeek);
    }

    public function testDateWithBadDate()
    {
        $dayOfWeek = kataDayOfWeek("50 13 300323");
        $this->assertFalse($dayOfWeek);
    }
}