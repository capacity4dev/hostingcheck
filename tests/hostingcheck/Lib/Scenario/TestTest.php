<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2005-2014 Serial Graphics. (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * Tests for Hostingcheck_Scenario_Test class.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Scenario_Test_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Test the constructor.
     */
    public function testConstructor()
    {
        $title = 'Info test';
        $info = 'Hostingcheck_Info_Text';
        $arguments = array('text' => 'Test 1234');
        $validators = array();

        $test = new Hostingcheck_Scenario_Test(
            $title,
            $info,
            $arguments,
            $validators
        );

        $this->assertEquals($title, $test->title());
        $this->assertEquals($info, $test->info());
        $this->assertEquals($arguments, $test->arguments());

        $validators = $test->validators();
        $this->assertInstanceOf('Hostingcheck_Scenario_Validators', $validators);
    }
}
