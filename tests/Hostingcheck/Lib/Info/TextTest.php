<?php
/**
 * Tests for Hostingcheck_Value_Info.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Info_Text_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Check success method.
     */
    public function testGetValue()
    {
        $info = new Hostingcheck_Info_Text();
        $this->assertInstanceOf(
            'Hostingcheck_Value_Text',
            $info->getValue()
        );
        $this->assertNull($info->getValue()->getValue());

        $arguments = array('text' => 'Foo value');
        $info = new Hostingcheck_Info_Text($arguments);
        $this->assertEquals($arguments['text'], $info->getValue()->getValue());
    }
}
