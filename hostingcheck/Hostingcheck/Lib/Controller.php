<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2014 Serial Graphics (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * Class Hostingcheck_Controller
 *
 * Main controller to decide, based on the GET request, what action to perform.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Controller
{
    /**
     * Configuration object.
     *
     * @var Hostingcheck_Config
     */
    protected $config;

    /**
     * Authentication object.
     *
     * @var Hostingcheck_Auth
     */
    protected $auth;

    /**
     * View object.
     * 
     * @var Hostingcheck_View
     */
    protected $view;

    /**
     * The possible actions
     * 
     * @var string
     */
    const ACTION_LOGOUT           = 'logout';
    const ACTION_RUN              = 'run';
    const ACTION_DOWNLOAD_REPORT  = 'download_report';
    const ACTION_DOWNLOAD_PHPINFO = 'download_phpinfo';


    /**
     * Constructor.
     *
     * @param Hostingcheck_Config $config
     *      The hostingcheck config.
     * @param Hostingcheck_Auth $auth
     *      The authentication object.
     * @param Hostingcheck_View $view
     *      The vew object to use in the controller.
     */
    public function __construct($config, $auth, $view)
    {
        $this->config = $config;
        $this->auth = $auth;

        // Set up the base variables in the view.
        $view->page_title  = $config->get('title', 'Hostingcheck');
        $view->show_logout = false;
        $view->show_actions = false;
        $this->view = $view;

        // Do not show the actions when downloading report.
        if (!preg_match('/^download_/', $this->getRequest())) {
            $this->view->show_actions = true;

            if($this->auth->isAuthenticated()) {
                $this->view->show_logout = true;
            }
        }
    }
  
    /**
     * Run the controller
     */
    public function run()
    {
        // check if logged in
        if(!$this->auth->isAuthenticated()) {
            echo $this->actionLogin();
            return;
        }
        
        switch($this->getRequest()) {
            case self::ACTION_LOGOUT:
                $output = $this->actionLogout();
                break;
                
            case self::ACTION_DOWNLOAD_REPORT:
                $this->actionDownloadReport();
                break;
              
            case self::ACTION_DOWNLOAD_PHPINFO:
                $this->actionDownloadPhpInfo();
                break;
              
            default:
                $output = $this->actionReport();
                break;
        }

        echo $output;
    }
    
    /**
     * Login action
     */
    public function actionLogin()
    {
        $this->view->urlLogin = self::getUrl();
        
        if(!empty($_POST)) {
            $login = $this->auth->login(
                $_POST['username'], 
                $_POST['password']
            );
            if($login) {
                $this->_redirect();
            }
            
            // add messages
        }

        return $this->view->renderTemplate('login');
    }
    
    /**
     * Logout
     */
    public function actionLogout()
    {
        $this->auth->logout();
        $this->_redirect();
    }
    
    /**
     * Download the report
     */
    public function actionDownloadReport()
    {
        $filename =
            $_SERVER['SERVER_NAME']
            . '_'
            . 'report'
            . '_'
            . date('Ymd-His')
            . '.html';

        $report = $this->actionReport();

        $this->download($filename, $report);
    }
    
    /**
     * Download the PHP info report
     */
    public function actionDownloadPhpInfo()
    {
        $filename =
            $_SERVER['SERVER_NAME']
            . '_'
            . 'phpinfo'
            . '_'
            . date('Ymd-His')
            . '.html';

        ob_start();
            phpinfo();
            $phpinfo = ob_get_contents();
        ob_end_clean();

        $this->download($filename, $phpinfo);
    }
    
    /**
     * Print out the report on screen
     */
    public function actionReport()
    {
        require_once HOSTINGCHECK_BASEPATH . 'Hostingcheck/scenario.php';
        /* @var $scenario array */
        $parser = new Hostingcheck_Scenario_Parser();
        $scenario = $parser->scenario($scenario);
        $runner = new Hostingcheck_Runner($scenario);
        $this->view->results = $runner->run();

        return $this->view->renderTemplate('results');
    }

    /**
     * Helper to force download of a report.
     *
     * @param string $filename
     *     The filename to use.
     * @param string $content
     *     The content of the download.
     */
    protected function download($filename, $content) {
        //header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        echo $content;
        exit;
    }

    /**
     * Get the request
     * 
     * @param void
     * 
     * @return array
     */
    protected function getRequest()
    {
        $do = null;
        if (isset($_GET['do'])) {
            $do = strip_tags($_GET['do']);
        }
        return $do;
    }
    
    /**
     * Get the url to the controller
     * 
     * @param string $action
     *     Optional action name.
     * @param array $arguments
     *     Optional get arguments.
     *
     * @return  string
     */
    protected function getUrl($action = null, $arguments = array()) {
        $urlHelper = new Hostingcheck_View_Url();
        return $urlHelper->Url(array(
            $action,
            $arguments
        ));
    }
    
    /**
     * Redirector
     * 
     * @param string $action
     *     The action to redirect to
     * 
     * @return void
     */
    protected function _redirect($action = NULL)
    {
        header('Location: ' . Hostingcheck_Controller::getUrl($action));
        exit;
    }
}