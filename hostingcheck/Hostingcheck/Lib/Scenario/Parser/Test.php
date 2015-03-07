<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2014 Serial Graphics (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * Parse a Test out of test config array.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Scenario_Parser_Test
    extends Hostingcheck_Scenario_Parser_Abstract
{
    /**
     * Parse a Test Scenario out of a test config.
     *
     * @param array $config
     *     Config array containing:
     *     - title      : The title for the test.
     *     - info       : The info class name to use to retrieve the info.
     *     - required   : Optional if it required that the retrieved info is
     *                    not empty.
     *     - args       : Optional arguments to retrieve the info data.
     *     - validators : Optional array of validator config arrays.
     *     - tests      : Optional array of child tests. These tests will only
     *                    be run if the test did not failed or is not supported.
     *
     * @return Hostingcheck_Scenario_Test
     */
    public function parse($config)
    {
        try {
            $scenario = $this->test($config);
        }
        catch (Hostingcheck_Scenario_Parser_Exception $e) {
            $scenario = $this->error($config, $e->getMessage());
        }

        return $scenario;
    }

    /**
     * Try to parse the Test out of the config.
     *
     * @param array $config
     *
     * @return Hostingcheck_Scenario_Test
     */
    protected function test($config)
    {
        $infoParser = new Hostingcheck_Scenario_Parser_Info(
            $this->services
        );
        $validatorsParser = new Hostingcheck_Scenario_Parser_Validators(
            $this->services
        );
        $testsParser = new Hostingcheck_Scenario_Parser_Tests(
            $this->services
        );

        $scenario = new Hostingcheck_Scenario_Test(
            $config['title'],
            $infoParser->parse($config),
            $validatorsParser->parse($config),
            $testsParser->parse($config)
        );

        return $scenario;
    }

    /**
     * Create a scenario with an error Info object.
     *
     * @param array $config
     *     The config array.
     * @param string $message
     *     The error message.
     *
     * @return Hostingcheck_Scenario_Test
     */
    protected function error($config, $message)
    {
        // Replace the Info class with a text one and a custom text.
        $info = new Hostingcheck_Info_Text(array('text' => '[SCENARIO ERROR]'));

        // Add the Exception message to our custom
        $errorValidator = new Hostingcheck_Validate_Error(
            array('message' => $message)
        );
        $validators = new Hostingcheck_Scenario_Validators();
        $validators->add($errorValidator);

        // We need the tests parser for nested tests.
        $testsParser = new Hostingcheck_Scenario_Parser_Tests(
            $this->services
        );

        $scenario = new Hostingcheck_Scenario_Test(
            $config['title'],
            $info,
            $validators,
            $testsParser->parse($config)
        );

        return $scenario;
    }

}
