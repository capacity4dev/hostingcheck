<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2005-2014 Serial Graphics. (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * Tests for Hostingcheck_Value_DateTime.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Check_Apache_Info_Version_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Check get value method.
     */
    public function testGetValue()
    {
        $version = new Check_Apache_Info_Version();
        $this->assertInstanceOf(
            'Hostingcheck_Value_NotSupported',
            $version->getValue()
        );
    }
}