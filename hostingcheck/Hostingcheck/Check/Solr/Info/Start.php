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
 * Info class to get the Solr start time.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Solr_Info_Start
  extends Hostingcheck_Info_Service_Abstract
{
    /**
     * Helper to extract and create the value.
     */
    protected function collectValue()
    {
        $conn = $this->service()->connection();
        /* @var $conn Apache_Solr_Service */

        if ($conn->system()->core) {
            $this->value = new Hostingcheck_Value_DateTime(new \DateTime($conn->system()->core->start));
        }
        else {
            $this->value = new Hostingcheck_Value_NotSupported();
        }

    }

    /**
     * Get the service from the info object.
     *
     * @return Check_Solr_Service_Solr
     */
    public function service()
    {
        return $this->service;
    }
}
