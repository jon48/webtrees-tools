<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\Webtrees;

use Piwik\Piwik;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Setting;

/**
 * Defines Settings for Webtrees.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    const WEBTREES_V1 = 1;
    const WEBTREES_V2 = 2;
    
    /** @var Setting */
    public $webtreesVersion;
    
    /** @var Setting */
    public $webtreesRootUrl;
    
    /** @var Setting */
    public $webtreesToken;
    
    /** @var Setting */
    public $webtreesTaskName;
    
    protected function init()
    {
        $this->webctreesVersion = $this->createWebtreesVersion();
        $this->webtreesRootUrl = $this->createWebtreesRootUrlSetting();
        $this->webtreesToken = $this->createWebtreesTokenSetting();
        $this->webtreesTaskName = $this->createWebtreesTaskNameSetting();
    }
    
    private function createWebtreesVersion() 
    {
        return $this->makeSetting('webtreesVersion', '', FieldConfig::TYPE_INT, function(FieldConfig $field) {
            $field->title = $this->t('WebtreesVersion');
            $field->description = $this->t('WebtreesVersionDescr');
            $field->uiControl = FieldConfig::UI_CONTROL_RADIO;
            $field->inlineHelp = $this->t('WebtreesVersionInlineHelp');
            $field->availableValues = array(
                self::WEBTREES_V1 => $this->t('WebtreesVersionV1'),
                self::WEBTREES_V2 => $this->t('WebtreesVersionV2')
            ); 
            $field->validate = function($value, Setting $setting) {
                if (!in_array($value, array(self::WEBTREES_V1, self::WEBTREES_V2))) {
                    throw new \Exception($this->t('WebtreesVersionError'));
                }
            };
        });
    }
    
    private function createWebtreesRootUrlSetting()
    {
        return $this->makeSetting('webtreesRootUrl', '', FieldConfig::TYPE_STRING, function(FieldConfig $field) {
            $field->title = $this->t('WebtreesRootUrl');
            $field->description = $this->t('WebtreesRootUrlDescr');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array('size' => 50);
            $field->inlineHelp = $this->t('WebtreesRootUrlInlineHelp');
            $field->validate = function($value, Setting $setting) {
                if (!preg_match('%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s', $value)) {
                    throw new \Exception($this->t('WebtreesRootUrlError'));
                }
            };
        });
    }    

    private function createWebtreesTokenSetting()
    {
        return $this->makeSetting('webtreesToken', '', FieldConfig::TYPE_STRING, function(FieldConfig $field) {
            $field->title = $this->t('WebtreesToken');
            $field->description = $this->t('WebtreesTokenDescr');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array('size' => 50);
            $field->inlineHelp = $this->t('WebtreesTokenInlineHelp');
            $field->validate = function($value, Setting $setting) {
                if (strlen($value)==0) {
                    throw new \Exception($this->t('WebtreesTokenError'));
                }
            };
        });        
    }
     
    private function createWebtreesTaskNameSetting()
    {
        return $this->makeSetting('webtreesTaskName', 'healthcheckmail', FieldConfig::TYPE_STRING, function(FieldConfig $field) {
            $field->title = $this->t('WebtreesTaskName');
            $field->description = $this->t('WebtreesTaskNameDescr');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->inlineHelp = $this->t('WebtreesTaskNameInlineHelp');
            $field->validate = function($value, Setting $setting) {
                if (strlen($value)==0) {
                    throw new \Exception($this->t('WebtreesTaskNameError'));
                }
            };
        });
    }
    
    private function t($key)
    {
        return Piwik::translate('Webtrees_' . $key);
    }
    
}
