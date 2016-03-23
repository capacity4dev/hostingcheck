<?php
/**
 * This file is part of Hostingcheck.
 */


/**
 * Base service to represent a solr connection.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Solr_Service_Solr extends Hostingcheck_Service_Abstract {
    /**
     * The solr host url.
     *
     * @var Apache_Solr_Service
     */
    protected $connection;

    /**
     * Constructor registers itself to the autoload registry.
     */
    public function __construct(Hostingcheck_Config $config) {
        parent::__construct($config);
        spl_autoload_register(array($this, 'loader'));
    }

    /**
     * The loader method.
     *
     * @param string $className
     *     The name of the class that needs to be automatically loaded.
     */
    private function loader($className) {
        $path = explode('_', $className);
        $namespace = $path[0];

        if ($namespace !== 'Apache') {
            return;
        }

        $path[-3] = 'Hostingcheck';
        $path[-2] = 'Check';
        $path[-1] = 'Solr';
        $path[0] = 'Service';
        ksort($path);

        $file = implode(DIRECTORY_SEPARATOR, $path) . '.php';

        if (!empty($file)) {
            $filePath = HOSTINGCHECK_BASEPATH . $file;

            require_once $filePath;
        }
    }


    /**
     * Checks if the service is available by trying to connect to it.
     *
     * @return bool
     */
    public function isAvailable() {
        $conn = $this->connection();
        return $conn->ping();
    }

    /**
     * Get the DB connection.
     *
     * If not connected yet, connect first.
     *
     * @return Apache_Solr_Service|false
     */
    public function connection() {
        return $this->connect();
    }

    /**
     * Connect to the database.
     *
     * @return Apache_Solr_Service|false
     */
    protected function connect() {
        if (is_null($this->connection)) {
            try {
                $this->connection = new Apache_Solr_Service(
                  $this->config->get('host'),
                  $this->config->get('port'),
                  $this->config->get('path')
                );
            } catch (Exception $exception) {
                $this->setErrorFromException($exception);
            }
        }

        return $this->connection;
    }
}
