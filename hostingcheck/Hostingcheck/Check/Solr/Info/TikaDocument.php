<?php
/**
 * This file is part of Hostingcheck.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2015 Serial Graphics (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/MIT
 */


/**
 * Info class to check Tika extractions.
 *
 * @author Kevin Van Ransbeeck <kevin.van.ransbeeck@gmail.com>
 */
class Check_Solr_Info_TikaDocument
  extends Hostingcheck_Info_Service_Abstract {

    /**
     * The name of the document to test.
     *
     * @var string
     */
    protected $name;

    /**
     * Documents to test for.
     *
     * @var array
     */
    protected $document;


    /**
     * {@inheritDoc}
     *
     * Supported arguments:
     * - name : the name of the extension.
     */
    public function __construct($arguments = array()) {
        if (empty($arguments['name'])) {
            $this->value = new Hostingcheck_Value_NotSupported();
            return;
        }

        $documents = $this->getDocuments();

        if (!array_key_exists($arguments['name'], $documents)) {
            $this->value = new Hostingcheck_Value_NotSupported(
              'Document not known.'
            );
            return;
        }

        $this->document = $documents[$arguments['name']];
        $this->name = $arguments['name'];

        parent::__construct($arguments);
    }

    /**
     * Metadata to test for different extensions.
     *
     * @return array
     */
    protected function getDocuments() {
        return array(
          'tika.pdf' => array(
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'Tika' . DIRECTORY_SEPARATOR,
            'type' => 'PDF',
            'keywords' => array('hostingcheck', 'pdf'),
          ),
          'tika.doc' => array(
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'Tika' . DIRECTORY_SEPARATOR,
            'type' => 'Microsoft Word Document (DOC)',
            'keywords' => array('hostingcheck', 'doc'),
          ),
          'tika.docx' => array(
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'Tika' . DIRECTORY_SEPARATOR,
            'type' => 'Microsoft Word Document (DOCX)',
            'keywords' => array('hostingcheck', 'docx'),
          ),
          'tika.xls' => array(
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'Tika' . DIRECTORY_SEPARATOR,
            'type' => 'Microsoft Excel Spreadsheet (XLS)',
            'keywords' => array('hostingcheck', 'xls'),
          ),
          'tika.xlsx' => array(
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'Tika' . DIRECTORY_SEPARATOR,
            'type' => 'Microsoft Excel Spreadsheet (XLSX)',
            'keywords' => array('hostingcheck', 'xlsx'),
          ),
          'tika.ppt' => array(
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'Tika' . DIRECTORY_SEPARATOR,
            'type' => 'Microsoft Powerpoint Presentation (PPT)',
            'keywords' => array('hostingcheck', 'ppt'),
          ),
          'tika.pptx' => array(
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'Tika' . DIRECTORY_SEPARATOR,
            'type' => 'Microsoft Powerpoint Presentation (PPTX)',
            'keywords' => array('hostingcheck', 'pptx'),
          ),
        );
    }

    /**
     * Helper to extract and create the value.
     */
    protected function collectValue() {
        $tika = $this->service()->path();

        try {
            $document = $this->document;
            $name = $this->name;

            $document_output = '';
            exec(
              "java -jar {$tika} -t {$document['path']}{$name}",
              $document_output
            );

            if (TRUE === $this->valid_document_output(
              $document_output,
              $document['keywords']
            )
            ) {
                $this->value = new Hostingcheck_Value_Boolean(TRUE);
            }
            else {
                $this->value = new Hostingcheck_Value_NotSupported(
                  sprintf(
                    'Could not find keywords %s',
                    implode(', ', $document['keywords'])
                  )
                );
            }
        } catch (Exception $e) {
            $this->value = new Hostingcheck_Value_NotSupported();
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


    /**
     * Test if tika document output is valid.
     *
     * @param array $document
     * @param string $keywords
     * @return boolean
     */
    protected function valid_document_output($document, $keywords) {
        if (!is_array($document)) {
            return FALSE;
        }

        // flatten document
        $document = implode(' ', $document);

        $success = TRUE;

        // search keywords
        foreach ($keywords as $keyword) {
            $pos = strpos($document, $keyword);
            var_dump($keyword, $pos);
            if ($pos === FALSE) {
                $success = FALSE;
            }
        }
        return $success;
    }
}
