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
 * Info class to get the Tika version.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Solr_Info_TikaVersion
  extends Hostingcheck_Info_Service_Abstract {
    /**
     * Helper to extract and create the value.
     */
    protected function collectValue() {
        $tika = $this->service()->path();

        try {
            $version = null;
            exec("java -jar {$tika} --version", $version);

            $this->value = new Hostingcheck_Value_Version(
              $version[0]
            );
        } catch (Exception $e)
        {
            $this->value = new Hostingcheck_Value_NotSupported();
        }
    }

    /**
     * Get the service from the info object.
     *
     * @return Solr_Service_Tika
     */
    public function service() {
        return $this->service;
    }
}
