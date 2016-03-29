<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2014 Serial Graphics (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * A set of services to use within the hostingcheck scenario.
 */
$services = array();


/**
 * MySQL service config:
 */
$services['db_mysql'] = array(
  'class' => 'Hostingcheck_Service_Database',
  'config' => array(
    'dsn' => 'mysql:host=[DBHOST];dbname=[DBNAME]',
    'username' => '[DBUSER]',
    'password' => '[DBPASS]',
    'options' => array(),
  ),
);

/**
 * Solr service config:
 */
$services['solr'] = array(
  'class' => 'Check_Solr_Service_Solr',
  'config' => array(
    'host' => '[SOLRHOST]', // E.g. "localhost".
    'port' => '[SOLRPORT]', // E.g. "8983",
    'path' => '/solr/capacity4more',
  ),
);

/**
 * Apache Tika config;
 */
$services['tika'] = array(
  'class' => 'Check_Solr_Service_Tika',
  'config' => array(
    'path' => '[TIKAPATH]', // E.g. "/usr/bin/".
    'jar' => '[TIKAJAR]' // E.g. "tika-app-1.11.jar".
  ),
);

/**
 * Memcache config;
 */
$services['memcache'] = array(
  'class' => 'Check_Memcache_Service_Memcache',
  'config' => array(
    'host' => '[MEMCACHEHOST]', // E.g. "localhost".
    'port' => '[MEMCACHEPORT]' // E.g. "11211".
  ),
);