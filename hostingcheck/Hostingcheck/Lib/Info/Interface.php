<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2014 Serial Graphics (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * Interface for the value object.
 *
 * The value object is used to retrieve information. That information will be
 * used to be validated or as information in the report.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
interface Hostingcheck_Info_Interface
{
    /**
     * Constructor.
     *
     * @param array $arguments
     *      The optional arguments needed to retrieve the value.
     */
    public function __construct($arguments = array());

    /**
     * Get the value.
     *
     * @return Hostingcheck_Value_Interface
     */
    public function getValue();
}