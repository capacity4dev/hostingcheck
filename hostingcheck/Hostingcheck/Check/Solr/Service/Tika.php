<?php
/**
 * This file is part of Hostingcheck.
 */


/**
 * Base service to represent the tika service.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Solr_Service_Tika extends Hostingcheck_Service_Abstract {
    /**
     * The full tika path.
     */
    protected $path;

    /**
     * Constructor registers itself to the autoload registry.
     */
    public function __construct(Hostingcheck_Config $config) {
        parent::__construct($config);
    }

    /**
     * Checks if the path is available.
     *
     * @return bool
     */
    public function isAvailable() {
        $path = $this->path();
        return file_exists($path);
    }

    /**
     * Get the Tika executable path.
     */
    public function path() {
        return $this->filepath();
    }

    /**
     * Assemble full Tika path.
     */
    protected function filepath() {
        if (is_null($this->path)) {
            try {
                $path = $this->config->get('path');
                $jar = $this->config->get('jar');

                $this->path = rtrim($path, '/') . DIRECTORY_SEPARATOR . $jar;
            } catch (Exception $exception) {
                $this->setErrorFromException($exception);
            }
        }

        return $this->path;
    }
}
