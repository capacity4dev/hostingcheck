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
 * Retrieve the Server OS information.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Check_Server_Info_OS extends Hostingcheck_Info_Abstract
{
    /**
     * {@inheritDoc}
     *
     * Supported arguments:
     * - None
     */
    public function __construct($arguments = array())
    {}

    /**
     * {@inheritDoc}
     */
    protected function collectValue()
    {
        $this->value = new Hostingcheck_Value_Text(
            php_uname()
        );
    }
}
