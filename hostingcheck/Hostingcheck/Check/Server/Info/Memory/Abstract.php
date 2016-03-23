<?php
/**
 * This file is part of Hostingcheck.
 */


/**
 * Retrieve Disk size information.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
abstract class Check_Server_Info_Memory_Abstract
    extends Hostingcheck_Info_Abstract
{
    
    /**
     * {@inheritDoc}
     *
     * Supported arguments:
     * - path : The file path from where the disk size should be calculated.
     *          By default the path where this script is located will be used.
     */
    public function __construct($arguments = array())
    {    
        
    }
    
    /**
     * {@inheritDoc}
     */
    protected function collectValue()
    {
        $mem = $this->getSize();
        
        if ($mem) {
            $this->value = $this->getSize();
        }
        else {
            $this->value = new Hostingcheck_Value_NotSupported();
        }
        
    }

    /**
     * Method to get the memory size.
     *
     * @return int
     */
    abstract protected function getSize();
    
    /**
     * Method to get the memory information from the system.
     *
     * @return array
     */
    protected function getMemoryInfo($item) {
        $fh = @fopen('/proc/meminfo','r');
        
        if (!$fh) {
            return 0;
        }
        $mem = 0;
        while ($line = fgets($fh)) {
            $pieces = array();
            if (preg_match('/^' . $item . ':\s+(\d+)\skB$/', $line, $pieces)) {
            $mem = $pieces[1];
            break;
            }
        }
        fclose($fh);
        
        return $mem;
    }
}
