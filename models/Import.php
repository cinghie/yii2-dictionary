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
	 * @param string $filePath
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
			$key = (string)$item['Key'];

			echo 'Indice '.$index.'<br>';

			if($key)
			{
				$newKeys  = new Keys();
				$keyExist = $newKeys::find()->findByKey($key);

				if(isset($keyExist)) {

					echo 'Key: ('.$key.') esiste già!<br>';

				} else {

					$newKeys->key = $key;
					$newKeys->save();
					$newKeysID = $newKeys->id;

					echo 'Key: ('.$key.') creata correttamente!<br>';

					if($newKeysID)
					{
						foreach (Yii::$app->controller->module->languages as $langTag)
						{
							$lang = substr($langTag,0,2);
							$value = (string)$item[$langTag] ?: '';

							$newValues = new Values();
							$newValues->key_id = $newKeysID;
							$newValues->value = $value;
							$newValues->lang = $lang;
							$newValues->lang_tag = $langTag;
							$newValues->save();

							echo $langTag.': '.$value.'<br>';
						}
					}

				}

			} else {

				echo 'Indice '.$index.'<br>';
				echo 'Key: NULL<br>';

				foreach (Yii::$app->controller->module->languages as $langTag)
				{
					$value = isset($item[$langTag]) ? (string)$item[$langTag] : '';

					echo $langTag.': '.$value.'<br>';
				}

				echo '<br>';
			}

			echo '#############<br><br>';

			$index++;
		}

		exit();
	}
}
