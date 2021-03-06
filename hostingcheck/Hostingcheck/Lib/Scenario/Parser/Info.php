<?php
/**
 * This file is part of Hostingcheck.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2015 Serial Graphics (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/MIT
 */


/**
 * Parse a Info object out of a validator config array.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Scenario_Parser_Info
    extends Hostingcheck_Scenario_Parser_Abstract
{
    /**
     * Parse the test::info out of the test config array.
     *
     * @param array $config
     *     Config containing:
     *     - info : The type of info that needs to be collected.
     *     - args : Optional arguments needed to collect the info.
     *     - service : An optional service name to use in the info object.
     *
     * @return Hostingcheck_Info_Interface
     *
     * @throws Hostingcheck_Scenario_Parser_Exception
     */
    public function parse($config)
    {
        if (empty($config['info'])) {
            throw new Hostingcheck_Scenario_Parser_Exception(
                'Info name is missing.'
            );
        }

        $className = $this->getClassName('Info', $config['info']);
        $arguments = $this->arguments($config);
        return new $className($arguments);
    }

    /**
     * Helper to extract the arguments from the config array.
     *
     * @param array $config
     *     The info config array.
     *
     * @return array $arguments
     */
    protected function arguments($config)
    {
        $arguments = array();
        if (!empty($config['args']) && is_array($config['args'])) {
            $arguments = $config['args'];
        }

        $this->addServiceToArguments($config, $arguments);
        $this->addFormatToArguments($arguments);

        return $arguments;
    }

    /**
     * Add the service to the arguments (if there is a service).
     *
     * @param array $config
     *     The config array.
     * @param array $arguments
     *     The arguments array.
     */
    protected function addServiceToArguments($config, &$arguments)
    {
        if (!empty($config['service'])) {
            $arguments['service'] = $this->services->seek(
                $config['service']
            );
        }
    }

    /**
     * Convert the format short name to a full classname.
     * Only if there is a format defined.
     *
     * @param array $arguments
     */
    protected function addFormatToArguments(&$arguments)
    {
        if (!empty($arguments['format'])) {
            $arguments['format'] = $this->getClassName(
                'Value',
                $arguments['format']
            );
        }
    }
}
