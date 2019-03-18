<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-dictionary
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-dictionary
 * @version 0.1.0
 */

namespace cinghie\dictionary;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\i18n\PhpMessageSource;

class Dictionary extends Module
{
    // Select Article Languages
	public $languages = [ 'en-GB' => 'en-GB' ];

	// Show Titles in the views
	public $showTitles = true;
    
   /**
	* @inheritdoc
    *
    * @throws InvalidParamException
    */
    public function init()
    {
        parent::init();
		    $this->registerTranslations();
    }
    
    /**
     * Translating module message
     */
    public function registerTranslations()
    {
		if (!isset(Yii::$app->i18n->translations['dictionary*'])) {
			Yii::$app->i18n->translations['articles*'] = [
				'class' => PhpMessageSource::class,
				'basePath' => __DIR__ . '/messages',
			];
		}
    }
}
