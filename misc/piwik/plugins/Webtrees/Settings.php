<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Webtrees;

use Piwik\Settings\SystemSetting;

/**
 * Defines Settings for Webtrees.
 *
 * Usage like this:
 * $settings = new Settings('Webtrees');
 * $settings->autoRefresh->getValue();
 * $settings->metric->getValue();
 *
 */
class Settings extends \Piwik\Plugin\Settings
{
    /** @var SystemSetting */
    public $webtreesRootUrl;
    
    /** @var SystemSetting */
    public $webtreesToken;
    
    /** @var SystemSetting */
    public $webtreesTaskName;

    protected function init()
    {
        $this->setIntroduction($this->t('PluginDescription'));

        $this->createWebtreesRootUrlSetting();
        $this->createWebtreesTokenSetting();
        $this->createWebtreesTaskNameSetting();
    }
    
	  private function createWebtreesRootUrlSetting()
	  {
	  	$this->webtreesRootUrl 					= new SystemSetting('webtreesRootUrl', $this->t('WebtreesRootUrl'));
	  	$this->webtreesRootUrl->type			= static::TYPE_STRING;
	  	$this->webtreesRootUrl->uiControlType	= static::CONTROL_TEXT;
	  	$this->webtreesRootUrl->uiControlAttributes = array('size' => 50);
	  	$this->webtreesRootUrl->inlineHelp		= $this->t('WebtreesRootUrlInlineHelp');
	  	$this->webtreesRootUrl->description		 = $this->t('WebtreesRootUrlDescr');
	  	$this->webtreesRootUrl->defaultValue	=  '';
	  	$this->webtreesRootUrl->validate		= function ($value, $setting) {
            if (!preg_match('%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s', $value)) {
                throw new \Exception($this->t('WebtreesRootUrlError'));
            }
        };
	  	
	  	$this->addSetting($this->webtreesRootUrl);
	  }
	  
	  private function createWebtreesTokenSetting()
	  {	  	
	  	$this->webtreesToken 					= new SystemSetting('webtreesToken', $this->t('WebtreesToken'));
	  	$this->webtreesToken->type				= static::TYPE_STRING;
	  	$this->webtreesToken->uiControlType		= static::CONTROL_TEXT;
	  	$this->webtreesToken->uiControlAttributes = array('size' => 50);
	  	$this->webtreesToken->inlineHelp		= $this->t('WebtreesTokenInlineHelp');
	  	$this->webtreesToken->description		 = $this->t('WebtreesTokenDescr');
	  	$this->webtreesToken->defaultValue		=  '';
	  	$this->webtreesToken->validate		= function ($value, $setting) {
	  		if (strlen($value)==0) {
	  			throw new \Exception($this->t('WebtreesTokenError'));
	  		}
	  	};
	  
	  	$this->addSetting($this->webtreesToken);
	  }
	  
	  private function createWebtreesTaskNameSetting()
	  {
	  	$this->webtreesTaskName 				= new SystemSetting('webtreesTaskName', $this->t('WebtreesTaskName'));
	  	$this->webtreesTaskName->type			= static::TYPE_STRING;
	  	$this->webtreesTaskName->uiControlType	= static::CONTROL_TEXT;
	  	$this->webtreesTaskName->inlineHelp		= $this->t('WebtreesTaskNameInlineHelp');
	  	$this->webtreesTaskName->description	= $this->t('WebtreesTaskNameDescr');
	  	$this->webtreesTaskName->defaultValue	= 'healthcheckmail';
	  	$this->webtreesTaskName->validate		= function ($value, $setting) {
	  		if (strlen($value)==0) {
	  			throw new \Exception($this->t('WebtreesTaskNameError'));
	  		}
	  	};
	  	 
	  	$this->addSetting($this->webtreesTaskName);
	  }
	  
	  private function t($key)
	  {
	  	return \Piwik\Piwik::translate('Webtrees_' . $key);
	  }
    
}
