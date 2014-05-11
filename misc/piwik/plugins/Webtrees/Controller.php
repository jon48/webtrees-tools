<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @category Piwik_Plugins
 * @package Webtrees
 */

namespace Piwik\Plugins\Webtrees;

use Piwik\API\ResponseBuilder;
use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin\ControllerAdmin;
use Piwik\View;

/**
 *
 * @package Piwik_Webtrees
 */
class Controller extends ControllerAdmin
{
    /**
     * Return the settings administration page
     */
    public function settings()
    {
        Piwik::checkUserHasSuperUserAccess();        
        $view = new View('@Webtrees/settings');
        
        $view->webtreesrooturl = API::getInstance()->getRootUrl();
        $view->webtreestoken = API::getInstance()->getToken();
        $view->webtreestaskname = API::getInstance()->getTaskName();
        
        $this->setBasicVariablesView($view);
        echo $view->render();
    }
    
    public function setGeneralSettings()
    {
    	Piwik::checkUserHasSuperUserAccess();
    	$response = new ResponseBuilder(Common::getRequestVar('format'));
    	try {
    		$this->checkTokenInUrl();
    		$rooturl = Common::getRequestVar('webtreesrooturl');
    		$token = Common::getRequestVar('webtreestoken');
    		$taskname = Common::getRequestVar('webtreestaskname');    		
    		
    		API::getInstance()->setRootUrl($rooturl);
    		API::getInstance()->setToken($token);
    		API::getInstance()->setTaskName($taskname);
    
    		$toReturn = $response->getResponse();
    	} catch (Exception $e) {
    		$toReturn = $response->getResponseException($e);
    	}
    	echo $toReturn;
    }
}
