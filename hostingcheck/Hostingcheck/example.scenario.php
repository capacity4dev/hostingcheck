<?php
/**
 * The scenario file contains an array with the test that the hostingcheck
 * should perform.
 */


/******************************************************************************
 *                                                                            *
 * TEST scenario structure.                                                   *
 *                                                                            *
 * Define the structure of the output report.                                 *
 * - The test groups will be listed in the same order as in this scenario.    *
 *                                                                            *
 ******************************************************************************/

/**
 * The hostingcheck is divided in test groups. Define those groups up-front.
 */
$info = array();
$server = array();
$web = array();
$db = array();
$solr = array();
$php = array();
$memcache = array();

/**
 * Set the groups in the desired order.
 */
$scenario = array(
  'info' => array(
    'title' => 'Information',
    'tests' => & $info,
  ),
  'server' => array(
    'title' => 'Server',
    'tests' => & $server,
  ),
  'web' => array(
    'title' => 'Web server (Apache)',
    'tests' => & $web,
  ),
  'db' => array(
    'title' => 'Database server (MySQL)',
    'tests' => & $db,
  ),
  'php' => array(
    'title' => 'Programming language (PHP)',
    'tests' => & $php,
  ),
  'solr' => array(
    'title' => 'Apache Solr & Tika',
    'tests' => & $solr,
  ),
  'memcache' => array(
    'title' => 'Memcache',
    'tests' => & $memcache,
  ),
);


/******************************************************************************
 *                                                                            *
 * TEST scenario tests.                                                       *
 *                                                                            *
 * Define all the tests (one by one).                                         *
 * - Each test will be a line in the report                                   *
 * - The tests will be listed in the same order as in the scenario.           *
 *                                                                            *
 ******************************************************************************/

$info[] = array(
  'title' => 'Report Date',
  'info' => 'DateTime',
);


/**
 * Example how to collect and validator information about the server hardware.
 */
$server[] = array(
  'title' => 'Operating System',
  'info' => 'Server_OS',
);
$server[] = array(
  'title' => 'Hostname',
  'info' => 'Server_Name',
);
$server[] = array(
  'title' => 'Total disk space',
  'info' => 'Server_DiskSize',
);
$server[] = array(
  'title' => 'Used disk space',
  'info' => 'Server_DiskSizeUsed',
);
$server[] = array(
  'title' => 'Free disk space',
  'info' => 'Server_DiskSizeFree',
  'validators' => array(
    array(
      'validator' => 'ByteSize',
      'args' => array('min' => '1G', 'max' => '1P'),
    ),
  ),
);
$server[] = array(
  'title' => 'Free disk space of root disk (/)',
  'info' => 'Server_DiskSizeFree',
  'args' => array('path' => '/'),
);


$server[] = array(
  'title' => 'Total memory',
  'info' => 'Server_MemoryTotal',
  'service' => 'solr',
  'validators' => array(
    array(
      'validator' => 'ByteSize',
      'args' => array('min' => '16G', 'max' => '1P'),
    ),
  ),
  'tests' => array(
    array(
      'title' => 'Free memory',
      'info' => 'Server_MemoryFree',
    ),
    array(
      'title' => 'Total Swap memory',
      'info' => 'Server_MemorySwapTotal',
      'service' => 'solr',
    ),
    array(
      'title' => 'Free Swap memory',
      'info' => 'Server_MemorySwapFree',
      'service' => 'solr',
    ),
  ),
);

$server[] = array(
  'title' => 'Number of processors',
  'info' => 'Server_ProcessorsNumber',
  'service' => 'solr',
  'validators' => array(
    array(
      'validator' => 'Version',
      'args' => array('min' => '8', 'max' => '16'),
    ),
  ),
  'required' => TRUE,
);


/**
 * Example how to collect and validator Apache configuration.
 */
$web[] = array(
  'title' => 'Apache version',
  'info' => 'Apache_Version',
  'tests' => array(
    array(
      'title' => 'Rewrite module',
      'info' => 'Apache_Module',
      'args' => array('name' => 'mod_rewrite'),
      'required' => TRUE,
    ),
    array(
      'title' => 'Deflate module',
      'info' => 'Apache_Module',
      'args' => array('name' => 'mod_deflate'),
      'required' => TRUE,
    ),
    array(
      'title' => 'Expires module',
      'info' => 'Apache_Module',
      'args' => array('name' => 'mod_expires'),
      'required' => TRUE,
    ),
    array(
      'title' => 'Include module',
      'info' => 'Apache_Module',
      'args' => array('name' => 'mod_include'),
      'required' => TRUE,
    ),
  ),
);


/**
 * Example how to collect and validator PHP configuration.
 */
$php[] = array(
  'title' => 'PHP Version',
  'info' => 'PHP_Version',
  'validators' => array(
    array(
      'validator' => 'Version',
      'args' => array('min' => '5.6', 'max' => '6'),
    ),
  ),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : Date',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'date'),
  'required' => TRUE,
  'tests' => array(
    array(
      'title' => 'Timezone',
      'info' => 'PHP_Config',
      'args' => array(
        'name' => 'date.timezone',
      ),
      'validators' => array(
        array(
          'validator' => 'Compare',
          'args' => array('equal', 'Antarctica/Troll'),
        ),
      ),
    ),
  ),
);

// PHP EXTENSIONS.
$php[] = array(
  'title' => 'Extension : APC',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'APC'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : GD',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'GD'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : bcmath',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'bcmath'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : bz2',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'bz2'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : calendar',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'calendar'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : ctype',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'ctype'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : CURL',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'CURL'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : DOM',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'DOM'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : exif',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'exif'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : gettext',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'gettext'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : imap',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'imap'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : json',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'json'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : ldap',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'ldap'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : mbstring',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'mbstring'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : mcrypt',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'mcrypt'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : memcached',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'memcached'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : soap',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'soap'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : sockets',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'sockets'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : XML',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'xml'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : xmlreader',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'xmlreader'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : xsl',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'xsl'),
  'required' => TRUE,
);
$php[] = array(
  'title' => 'Extension : zip',
  'info' => 'PHP_Extension',
  'args' => array('name' => 'zip'),
  'required' => TRUE,
);

$php[] = array(
  'title' => 'Config : Memory limit',
  'info' => 'PHP_Config',
  'args' => array(
    'name' => 'memory_limit',
    'format' => 'Byte',
  ),
  'validators' => array(
    array(
      'validator' => 'ByteSize',
      'args' => array('min' => '512M'),
    ),
  ),
);
$php[] = array(
  'title' => 'Config : Upload Max Filesize',
  'info' => 'PHP_Config',
  'args' => array(
    'name' => 'upload_max_filesize',
    'format' => 'Byte',
  ),
  'validators' => array(
    array(
      'validator' => 'ByteSize',
      'args' => array('min' => '32M'),
    ),
  ),
);
$php[] = array(
  'title' => 'Config : Post Max Size',
  'info' => 'PHP_Config',
  'args' => array(
    'name' => 'post_max_size',
    'format' => 'Byte',
  ),
  'validators' => array(
    array(
      'validator' => 'ByteSize',
      'args' => array('min' => '32M'),
    ),
  ),
);
$php[] = array(
  'title' => 'Config : Session Cache limiter',
  'info' => 'PHP_Config',
  'args' => array(
    'name' => 'session.cache_limiter',
  ),
  'validators' => array(
    array(
      'validator' => 'Compare',
      'args' => array('equal', 'nocache'),
    ),
  ),
);
$php[] = array(
  'title' => 'Config : Session Auto start',
  'info' => 'PHP_Config',
  'args' => array(
    'name' => 'session.auto_start',
    'format' => 'Boolean',
  ),
  'validators' => array(
    array(
      'validator' => 'False',
    ),
  ),
);
$php[] = array(
  'title' => 'Config : Expose PHP',
  'info' => 'PHP_Config',
  'args' => array(
    'name' => 'expose_php',
    'format' => 'Boolean',
  ),
  'validators' => array(
    array(
      'validator' => 'False',
    ),
  ),
);

$solr[] = array(
  'title' => 'Solr Service available',
  'info' => 'Service_Available',
  'service' => 'solr',
  'required' => TRUE,
  'tests' => array(
    array(
      'title' => 'Schema Version',
      'info' => 'Solr_Version',
      'validators' => array(
        array(
          'validator' => 'Version',
          'args' => array('min' => 'drupal-'),
        ),
      ),
    ),
    array(
      'title' => 'Start Time',
      'info' => 'Solr_Start',
    ),
    array(
      'title' => 'Instance directory',
      'info' => 'Solr_Instance',
    ),
    array(
      'title' => 'Solr Lucene version',
      'info' => 'Solr_LuceneVersion',
      'required' => TRUE,
      'validators' => array(
        array(
          'validator' => 'Version',
          'args' => array('min' => '5', 'max' => 6),
        ),
      ),
    ),
  ),
);

$solr[] = array(
  'title' => 'Apache Tika Service available',
  'info' => 'Service_Available',
  'service' => 'tika',
  'required' => TRUE,
  'tests' => array(
    array(
      'title' => 'Tika Version',
      'info' => 'Solr_TikaVersion',
      'validators' => array(
        array(
          'validator' => 'Version',
          'args' => array('min' => 'Apache Tika 1.10'),
        ),
      ),
    ),
    array(
      'title' => 'Extract PDF',
      'info' => 'Solr_TikaDocument',
      'args' => array(
        'name' => 'tika.pdf',
        'format' => 'Boolean',
      ),
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
    array(
      'title' => 'Extract DOC',
      'info' => 'Solr_TikaDocument',
      'args' => array(
        'name' => 'tika.doc',
        'format' => 'Boolean',
      ),
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
    array(
      'title' => 'Extract DOCX',
      'info' => 'Solr_TikaDocument',
      'args' => array(
        'name' => 'tika.docx',
        'format' => 'Boolean',
      ),
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
    array(
      'title' => 'Extract XLS',
      'info' => 'Solr_TikaDocument',
      'args' => array(
        'name' => 'tika.xls',
        'format' => 'Boolean',
      ),
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
    array(
      'title' => 'Extract XLSX',
      'info' => 'Solr_TikaDocument',
      'args' => array(
        'name' => 'tika.xlsx',
        'format' => 'Boolean',
      ),
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
    array(
      'title' => 'Extract PPT',
      'info' => 'Solr_TikaDocument',
      'args' => array(
        'name' => 'tika.ppt',
        'format' => 'Boolean',
      ),
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
    array(
      'title' => 'Extract PPTX',
      'info' => 'Solr_TikaDocument',
      'args' => array(
        'name' => 'tika.pptx',
        'format' => 'Boolean',
      ),
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
  )
);

/**
 * Example how to collect and validator information about the Database(s).
 */
$db[] = array(
  'title' => 'MySQL service available',
  'info' => 'Service_Available',
  'service' => 'db_mysql',
  'required' => TRUE,
  'tests' => array(
    array(
      'title' => 'Version',
      'info' => 'MySQL_Version',
      'validators' => array(
        array(
          'validator' => 'Version',
          'args' => array('min' => '5.6', 'max' => '6'),
        ),
      ),
    ),
    array(
      'title' => 'query_cache_type',
      'info' => 'MySQL_Config',
      'args' => array(
        'name' => 'query_cache_type',
      ),
    ),
    array(
      'title' => 'innodb_file_per_table',
      'info' => 'MySQL_Config',
      'args' => array(
        'name' => 'innodb_file_per_table',
        'format' => 'Boolean',
      ),
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
    array(
      'title' => 'innodb_buffer_pool_size',
      'info' => 'MySQL_Config',
      'args' => array(
        'name' => 'innodb_buffer_pool_size',
        'format' => 'Byte',
      ),
    ),
    array(
      'title' => 'max_allowed_packet',
      'info' => 'MySQL_Config',
      'args' => array(
        'name' => 'max_allowed_packet',
        'format' => 'Byte',
      ),
      'validators' => array(
        array(
          'validator' => 'ByteSize',
          'args' => array('min' => '32M'),
        ),
      ),
    ),
  ),
);

$memcache[] = array(
  'title' => 'Memcache Service available',
  'info' => 'Service_Available',
  'service' => 'memcache',
  'required' => TRUE,
  'tests' => array(
    array(
      'title' => 'Memcache Status',
      'info' => 'Memcache_Status',
      'validators' => array(
        array(
          'validator' => 'True',
        ),
      ),
    ),
    array(
      'title' => 'Memcache Version',
      'info' => 'Memcache_Version',
      'validators' => array(
        array(
          'validator' => 'Version',
          'args' => array('min' => '1.4.0'),
        ),
      ),
    ),
  )
);
