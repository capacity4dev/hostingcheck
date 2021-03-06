<?php
/**
 * Tests for Hostingcheck_Value_DateTime.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Info_DateTime_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Check success method.
     */
    public function testGetValue()
    {
        // Default date = now.
        $info = new Hostingcheck_Info_DateTime();
        $this->assertInstanceOf(
            'Hostingcheck_Value_DateTime',
            $info->getValue()
        );
        $this->assertInstanceOf(
            'DateTime',
            $info->getValue()->getValue()
        );

        // Based on given date-time.
        $date = new DateTime('2014-05-25 13:31:15');
        $arguments = array(
            'date' => $date->format('Y-m-d H:i:s'),
        );
        $info = new Hostingcheck_Info_DateTime($arguments);
        $this->assertEquals(
            $date->format('Y-m-d H:i:s'),
            $info->getValue()
                 ->getValue()
                 ->format('Y-m-d H:i:s')
        );
    }
}
