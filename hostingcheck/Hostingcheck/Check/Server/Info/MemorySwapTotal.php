<?php
/**
 * This file is part of Hostingcheck.
 */

/**
 * Retrieve the total swap memory size.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Server_Info_MemorySwapTotal extends Check_Server_Info_Memory_Abstract
{
    /**
     * Get the total swap memory size.
     *
     * @return int
     */
    protected function getSize()
    {
        return $this->getMemoryInfo('SwapTotal');
    }
}
