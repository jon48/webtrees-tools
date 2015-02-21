<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Webtrees;

class Tasks extends \Piwik\Plugin\Tasks
{
	/**
	 * @var \Psr\Log\LoggerInterface
	 */
	private $logger;
	
    public function schedule()
    {
    	$this->weekly('triggerWebtreesAdminTasks', null, self::LOWEST_PRIORITY);
    }

    public function triggerWebtreesAdminTasks(){
    	
    	$settings = new Settings();
    	
    	$this->logger = \Piwik\Container\StaticContainer::get('Psr\Log\LoggerInterface');
    	
    	$this->logger->info('Webtrees Admin Task triggered');
    	$rooturl = $settings->getSetting('webtreesRootUrl');
    	if(!$rooturl || strlen($rooturl->getValue()) === 0) return;
    	
    	$token = $settings->getSetting('webtreesToken');;
    	if(!$token || strlen($token->getValue()) ===0 ) return;
    	
    	$taskname = $settings->getSetting('webtreesTaskName');;
    	if(!$taskname || strlen($taskname->getValue()) === 0) return;

    	$url = sprintf('%1$s/module.php?mod=perso_admintasks&mod_action=trigger&force=%2$s&task=%3$s',
    			$rooturl->getValue(),
    			$token->getValue(),
    			$taskname->getValue()
		);
    	$this->logger->info('webtrees url : {url}', array('url' => $url));
    	 
    	try {
    		\Piwik\Http::sendHttpRequest($url, Webtrees::SOCKET_TIMEOUT);
    	} catch (Exception $e) { $this->logger->warning('an error occured', array('exception' => $e)); }
    }
}