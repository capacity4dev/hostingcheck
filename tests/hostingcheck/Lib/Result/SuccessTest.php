<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2005-2014 Serial Graphics. (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * Tests for Hostingcheck_Result_Success value object.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Result_Success_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Get the result value method.
     */
    public function testGetValue()
    {
        $result = new Hostingcheck_Result_Success(null);
        $this->assertNull($result->getValue());

        $result = new Hostingcheck_Result_Success('foo');
        $this->assertEquals('foo', $result->getValue());
    }
}
