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
use cinghie\traits\ViewsHelpersTrait;
use yii\db\ActiveQuery;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%dictionary_keys}}".
 *
 * @property int $id
 * @property string $key
 *
 * @property Values[] $dictionaryValues
 */
class Keys extends \yii\db\ActiveRecord
{
	use ViewsHelpersTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dictionary_keys}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('traits', 'ID'),
            'key' => Yii::t('traits', 'Key'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDictionaryValues()
    {
        return $this->hasMany(Values::class, ['key_id' => 'id']);
    }

	/**
	 * @param bool $lang
	 *
	 * @return string
	 */
	public function getTranslation($lang)
	{
		$translation = $this->hasOne(Values::class, ['key_id' => 'id'])->where(['lang' => $lang])->one();

		return $translation;
	}

	/**
	 * @param string $field
	 * @param bool $lang
	 *
	 * @return string
	 */
	public function getTranslationField($field,$lang)
	{
		$translation = $this->getTranslation($lang);

		return $translation[$field];
	}

	/**
	 * @param bool $lang
	 *
	 * @return string
	 */
	public function getTranslationValue($lang)
    {
    	$translation = $this->hasOne(Values::class, ['key_id' => 'id'])->select('value')->where(['lang' => $lang])->one();

		return $translation['value'];
    }

	/**
	 * @param string $valueName
	 *
	 * @return string
	 */
	public function getTranslationInput($valueName,$lang)
    {
    	if($this->isNewRecord) {
    		return Html::textInput($valueName, '', ['class' => 'form-control']);
	    }

	    return Html::textInput($valueName, $this->getTranslationValue($lang), ['class' => 'form-control']);
    }

    /**
     * {@inheritdoc}
     *
     * @return KeysQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KeysQuery( static::class );
    }
}
