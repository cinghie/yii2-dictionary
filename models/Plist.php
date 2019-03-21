<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-dictionary
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-dictionary
 * @version 0.3.0
 */

namespace cinghie\dictionary\models;

use CFPropertyList\CFDictionary;
use CFPropertyList\CFPropertyList;
use CFPropertyList\CFString;
use CFPropertyList\IOException;

class Plist
{
	/**
	 * @param array $array
	 * @param string $lang
	 * @param string $plist_path
	 *
	 * @return string
	 * @throws IOException
	 */
	public static function createPlistFile($array,$lang,$plist_path)
	{
		/**
		 * create a new CFPropertyList instance without loading any content
		 */
		$plist = new CFPropertyList();

		/**
		 * The Root element of the PList is a Dictionary
		 */
		$dictionary = new CFDictionary();
		$plist->add($dictionary);

		$filename   = 'Localizable_'.$lang.'.plist';
		$plist_file = $plist_path.$filename;

		foreach ($array as $item)
		{
			if($item['key']) {
				$dictionary->add( $item['key'], new CFString( $item['translation'] ) );
			}
		}

		$plist->saveXML($plist_file);

		return $plist_file;
	}

	/**
	 * Download File
	 *
	 * @param string $filePath
	 *
	 * @return \yii\console\Response|\yii\web\Response
	 * @throws NotFoundHttpException
	 */
	public function downloadFile($filePath)
	{
		if (file_exists($filePath)) {
			return Yii::$app->response->sendFile($filePath);
		}

		throw new NotFoundHttpException("{$filePath} is not found!");
	}
}
