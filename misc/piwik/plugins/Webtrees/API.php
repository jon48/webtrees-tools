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

use Piwik\Piwik;
use Piwik\Option;
use Piwik\Tracker\Cache;

/**
 * The Webtrees API gives you full control on Webtrees settings in Piwik (create, update).
 
 * @package Webtrees
 * @method static \Piwik\Plugins\Webtrees\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
	const ROOT_URL = 'webtreesRootUrl';
	const TOKEN = 'webtreesToken';
	const TASK_NAME = 'webtreesTaskName';
	
	public static function getRootUrl()
	{
		Piwik::checkUserHasSuperUserAccess();
		$rooturl = Option::get(self::ROOT_URL);
		if ($rooturl !== false) {
			return $rooturl;
		}
		return '';
	}	

	public static function setRootUrl($rooturl)
	{
		Piwik::checkUserHasSuperUserAccess();
		if (strlen($rooturl) == 0 ) {
			throw new Exception('The webtrees root url must be a valid URL.');
		}
		Option::set(self::ROOT_URL, $rooturl);
		Cache::deleteTrackerCache();
		return true;
	}
	
	public static function getToken()
	{
		Piwik::checkUserHasSuperUserAccess();
		$token = Option::get(self::TOKEN);
		if ($token !== false) {
			return $token;
		}
		return '';
	}
	
	public static function setToken($token)
	{
		Piwik::checkUserHasSuperUserAccess();
		if (strlen($token) == 0 ) {
			throw new Exception('The token is not valid.');
		}
		Option::set(self::TOKEN, $token);
		Cache::deleteTrackerCache();
		return true;
	}
	
	public static function getTaskName()
	{
		Piwik::checkUserHasSuperUserAccess();
		$taskname = Option::get(self::TASK_NAME);
		if ($taskname !== false) {
			return $taskname;
		}
		return 'healthcheckmail';
	}
	
	public static function setTaskName($taskname)
	{
		Piwik::checkUserHasSuperUserAccess();
		if (strlen($taskname) == 0 ) {
			throw new Exception('The taskname is not valid.');
		}
		Option::set(self::TASK_NAME, $taskname);
		Cache::deleteTrackerCache();
		return true;
	}
	
}
