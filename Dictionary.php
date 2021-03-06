<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-dictionary
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-dictionary
 * @version 0.3.1
 */

namespace cinghie\dictionary;

use RuntimeException;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\i18n\PhpMessageSource;

class Dictionary extends Module
{
    // Select Article Languages
	public $languages = ['en-GB' => 'en-GB'];

	// Admin Rules
	public $dictionaryRoles = ['admin'];

	// Model map
	public $modelMap = [];

	// Page Size DataProvider
	public $pageSize = 50;

	// Plist Folder Path
	public $plistFolderPath = '@webroot/dictionary/plist/';

	// Upload Folder Path
	public $uploadFolderPath = '@webroot/dictionary/csv/';

	// Upload Max File Size = 1024 * 1024 * 5
	public $uploadMaxFileSize = 5242880;

	// Show Plist Download
	public $showPlistDownload = false;

	// Show Titles in the views
	public $showTitles = true;
    
   /**
	* @inheritdoc
    *
    * @throws InvalidParamException
    */
    public function init()
    {
        $this->registerTranslations();
        $this->setupPlistDirectory();
        $this->setupUploadDirectory();

	    parent::init();
    }
    
    /**
     * Translating module message
     */
    public function registerTranslations()
    {
		if (!isset(Yii::$app->i18n->translations['dictionary*'])) {
			Yii::$app->i18n->translations['dictionary*'] = [
				'class' => PhpMessageSource::class,
				'basePath' => __DIR__ . '/messages',
			];
		}
    }

	/**
	 * Setup image directory if it's not exist yet
	 *
	 * @throws InvalidParamException
	 */
	protected function setupPlistDirectory()
	{
		if( ! file_exists( Yii::getAlias( $this->plistFolderPath ) ) && ! mkdir( Yii::getAlias( $this->plistFolderPath ), 0755, true ) && ! is_dir( Yii::getAlias( $this->plistFolderPath ) ) ) {
			throw new RuntimeException( sprintf( 'Directory "%s" was not created', Yii::getAlias( $this->plistFolderPath ) ) );
		}
	}

	/**
	 * Setup image directory if it's not exist yet
	 *
	 * @throws InvalidParamException
	 */
	protected function setupUploadDirectory()
	{
		if( ! file_exists( Yii::getAlias( $this->uploadFolderPath ) ) && ! mkdir( Yii::getAlias( $this->uploadFolderPath ), 0755, true ) && ! is_dir( Yii::getAlias( $this->uploadFolderPath ) ) ) {
			throw new RuntimeException( sprintf( 'Directory "%s" was not created', Yii::getAlias( $this->uploadFolderPath ) ) );
		}
	}
}
