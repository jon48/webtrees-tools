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

use Piwik\Menu\MenuAdmin;
use Piwik\Piwik;
use Piwik\ScheduledTask;
use Piwik\ScheduledTime\Weekly;
use Piwik\Log;

class Webtrees extends \Piwik\Plugin
{
	const SOCKET_TIMEOUT = 10;
	
    /**
     * @see Piwik_Plugin::getListHooksRegistered
     */
    public function getListHooksRegistered() {
    	return array(
    			'AssetManager.getJavaScriptFiles'	=> 'getJsFiles',
    			'Menu.Admin.addItems' 				=> 'addMenu',
    			'TaskScheduler.getScheduledTasks' 	=> 'getScheduledTasks',
    	);
    }
    
    /**
     * Return list of plug-in specific JavaScript files to be imported by the asset manager
     *
     * @see Piwik_AssetManager
     */
    public function getJsFiles(&$jsFiles)
    {
    	$jsFiles[] = "plugins/Webtrees/javascripts/settings.js";
    }
    
    /**
     * Gets all scheduled tasks executed by this plugin.
     *
     */
    public function getScheduledTasks(&$tasks)
    {    
    	$triggerWebtreesAdminTasksTask = new ScheduledTask(
    			$this,
    			'triggerWebtreesAdminTasks',
    			null,
    			new Weekly(),
    			ScheduledTask::LOWEST_PRIORITY
    	);
    	$tasks[] = $triggerWebtreesAdminTasksTask;
    }
    
    public function triggerWebtreesAdminTasks(){    
    	Log::info('Webtrees Admin Task triggered');
    	$rooturl = API::getInstance()->getRootUrl();    	
    	if(strlen($rooturl) == 0) return;
    	
    	$token = API::getInstance()->getToken();
    	if(strlen($token) == 0) return;
    	
    	$taskname = API::getInstance()->getTaskName();
    	if(strlen($taskname) == 0) return;
    	
    	$url = sprintf('%1$s/module.php?mod=perso_admintasks&mod_action=trigger&force=%2$s&task=%3$s', $rooturl, $token, $taskname);
    	//Log::info('webtrees url : '.$url);
    	
    	try {
    		\Piwik\Http::sendHttpRequest($url, self::SOCKET_TIMEOUT);
    	} catch (Exception $e) { }    	
    }
    
    public function addMenu()
    {
    	MenuAdmin::getInstance()->add(
	    	'General_Settings', 'Webtrees_MenuSettings',
	    	array('module' => 'Webtrees', 'action' => 'settings'),
    		Piwik::hasUserSuperUserAccess(),
    		$order = 30
    	);
    }
    
}
