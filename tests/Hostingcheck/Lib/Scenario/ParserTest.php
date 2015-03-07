<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2005-2014 Serial Graphics. (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * Tests for Hostingcheck_Scenario_Parser class.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Scenario_Parser_TestCase extends PHPUnit_Framework_TestCase
{


    /**
     * Test the group parser without tests.
     */
    public function testGroupParserWithoutTests()
    {
        $name = 'test-group';
        $title = 'Test group';
        $config = array(
            'title' => $title,
        );

        $parser = new Hostingcheck_Scenario_Parser($this->getServices());

        $group = $parser->group($name, $config);
        $this->assertInstanceOf('Hostingcheck_Scenario_Group', $group);
        $this->assertEquals($name, $group->name());
        $this->assertEquals($title, $group->title());
        $this->assertCount(0, $group->tests());
    }

    /**
     * Test the group parser without tests.
     */
    public function testGroupParserWithTests()
    {
        $name = 'test-group';
        $title = 'Test group';
        $config = array(
            'title' => $title,
            'tests' => array(
                array(
                    'title' => 'Test parser',
                    'info' => 'Text',
                    'args' => array('text' => 'Test text'),
                    'validators' => array(
                        array(
                            'validator' => 'ByteSize',
                            'args' => array('min' => '15M'),
                        )
                    ),
                ),
            )
        );

        $parser = new Hostingcheck_Scenario_Parser($this->getServices());

        $group = $parser->group($name, $config);
        $this->assertEquals($name, $group->name());
        $this->assertEquals($title, $group->title());
        $this->assertCount(1, $group->tests());
    }

    /**
     * Test scenario without groups (empty).
     */
    public function testScenarioWithoutGroups()
    {
        $config = array();

        $parser = new Hostingcheck_Scenario_Parser($this->getServices());

        $scenario = $parser->scenario($config);
        $this->assertInstanceOf('Hostingcheck_Scenario', $scenario);
        $this->assertCount(0, $scenario);
    }

    /**
     * Test scenario with groups.
     */
    public function testScenarioWithGroups()
    {
        $config = array(
            'group1' => array(
                'title' => 'Group 1',
            ),
            'group2' => array(
                'title' => 'Group 2',
            )
        );

        $parser = new Hostingcheck_Scenario_Parser($this->getServices());

        $scenario = $parser->scenario($config);
        $this->assertInstanceOf('Hostingcheck_Scenario', $scenario);
        $this->assertCount(2, $scenario);
    }

    /**
     * Create a services container.
     */
    protected function getServices()
    {
        $services = new Hostingcheck_Services();
        return $services;
    }
}
