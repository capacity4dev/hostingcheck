<?php
/**
 * This file is part of Hostingcheck.
 */

/**
 * Retrieve the free memory size.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Server_Info_MemoryTotal extends Hostingcheck_Info_Service_Abstract
{
    /**
     * Helper to extract and create the value.
     */
    protected function collectValue() {
        $conn = $this->service()->connection();
        /* @var $conn Apache_Solr_Service */

        if ($conn->system()->system) {
            $this->value = new Hostingcheck_Value_Byte(
              $conn->system()->system->totalPhysicalMemorySize
            );
        }
        else {
            $this->value = new Hostingcheck_Value_NotSupported(
              'Please configure the SOLR service first!'
            );
        }

    }

    /**
     * Get the service from the info object.
     *
     * @return Hostingcheck_Service_Database
     */
    public function service() {
        return $this->service;
    }
}
