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

namespace cinghie\dictionary\models;

use Yii;
use yii\db\ActiveRecord;

class Import extends ActiveRecord
{
	public $importKeys;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[['importKeys'], 'file', 'extensions' => 'csv', 'maxSize' => Yii::$app->controller->module->uploadMaxFileSize],
		];
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return [
			'importKeys' => Yii::t('dictionary','Import Keys'),
		];
	}

	/**
	 * Import Keys form CSV
	 *
	 * @param $filePath
	 */
	public function importKeys($filePath)
	{
		// Create Array with column name
		$csv = array();
		$i = 0;

		if (($handle = fopen($filePath, 'rb')) !== false)
		{
			$columns = fgetcsv($handle, 1000, ';');

			while (($row = fgetcsv($handle, 1000, ';')) !== false) {
				$csv[$i] = array_combine($columns, $row);
				$i++;
			}

			fclose($handle);
		}

		$index = 0;

		foreach ($csv as $item)
		{
			$key = $item['Key'];

			if($key) {

				foreach (Yii::$app->controller->module->languages as $langTag)
				{

				}

			} else {

				var_dump($item); echo '<br>';
				echo 'Key not exist!<br>';
			}

			echo '<pre>'; var_dump($item); echo '</pre>';

			$index++;

			if($index = 2) {
				exit();
			}
		}

		var_dump($csv); exit();
	}
}
