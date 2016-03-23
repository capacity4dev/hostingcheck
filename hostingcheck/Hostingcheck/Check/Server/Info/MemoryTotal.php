<?php
/**
 * This file is part of Hostingcheck.
 */

/**
 * Retrieve the total memory size.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Server_Info_MemoryTotal extends Check_Server_Info_Memory_Abstract
{
    /**
     * Get the total memory size.
     *
     * @return int
     */
    protected function getSize()
    {
        return $this->getMemoryInfo('TotalMem');
    }
}
