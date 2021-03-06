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
 * Info class to get the MySQL version.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Check_MySQL_Info_Version
    extends Hostingcheck_Info_Service_Abstract
{
    /**
     * Helper to extract and create the value.
     */
    protected function collectValue()
    {
        $conn = $this->service()->connection();
        /* @var $conn PDO */

        $stmnt = $conn->prepare('SELECT VERSION() AS MYSQL_VERSION');
        $stmnt->execute();
        $row = $stmnt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            preg_match('/^[0-9.]*/', $row['MYSQL_VERSION'], $matches);
            $this->value = new Hostingcheck_Value_Version($matches[0]);
        }
        else {
            $this->value = new Hostingcheck_Value_NotSupported();
        }

    }

    /**
     * Get the service from the info object.
     *
     * @return Hostingcheck_Service_Database
     */
    public function service()
    {
        return $this->service;
    }
}
