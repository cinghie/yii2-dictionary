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

namespace cinghie\dictionary\models;

use CFPropertyList\CFDictionary;
use CFPropertyList\CFPropertyList;
use CFPropertyList\CFString;
use CFPropertyList\IOException;
use Exception;

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
	 * Generate zip file for upload
	 *
	 * @param string $plist_path
	 */
	public static function createPlistZip($plist_path)
	{
		$files   = $plist_path.'Localizable_*.plist';
		$zipFile = new \ZipArchive();
		$zipName = $plist_path.'Plist.zip';
		$filesPlists = array();

		if ($zipFile->open($zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
			die ( 'An error occurred creating your ZIP file.' );
		}

		foreach (glob($files) as $file) {
			$zipFile->addFile($file, $zipName);
		}

		$zipFile->close();

		var_dump($filesPlists);
		exit();
	}
}
