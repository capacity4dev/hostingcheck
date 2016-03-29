<?php
/**
 * This file is part of Hostingcheck.
 */


/**
 * Base service to represent a solr connection.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Memcache_Service_Memcache extends Hostingcheck_Service_Abstract {
    /**
     * The memcache host url.
     *
     * @var Apache_Solr_Service
     */
    protected $connection;

    /**
     * Constructor registers itself to the autoload registry.
     */
    public function __construct(Hostingcheck_Config $config) {
        parent::__construct($config);
    }

    /**
     * Checks if the service is available by trying to connect to it.
     *
     * @return bool
     */
    public function isAvailable() {
        $server = 'localhost';
        $conn = $this->connection()->connect($server);

        return (bool)$conn;
    }

    /**
     * Get the DB connection.
     *
     * If not connected yet, connect first.
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
                $memcache = new Memcache();

                $this->connection = $memcache;
            } catch (Exception $exception) {
                $this->setErrorFromException($exception);
            }
        }

        return $this->connection;
    }
}
