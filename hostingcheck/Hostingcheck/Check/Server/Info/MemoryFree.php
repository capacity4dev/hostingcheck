<?php
/**
 * This file is part of Hostingcheck.
 */

/**
 * Retrieve the free memory size.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Check_Server_Info_MemoryFree extends Check_Server_Info_Memory_Abstract
{
    /**
     * Get the free memory size.
     *
     * @return int
     */
    protected function getSize()
    {
        return $this->getMemoryInfo('MemFree');
    }
}
