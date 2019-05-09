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

use Yii;
use cinghie\traits\ViewsHelpersTrait;
use kartik\grid\CheckboxColumn;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%dictionary_keys}}".
 *
 * @property integer $id
 * @property string $key
 *
 * @property ActiveQuery $values
 *
 * @property array $gridColumns
 * @property Values[] $dictionaryValues
 */
class Keys extends ActiveRecord
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
	        [['key'], 'unique', 'message' => Yii::t('dictionary','This key already exist')],
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
    public function getValues()
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
	 * @param string $lang
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
	 * @return array
	 */
	public function getGridColumns()
    {
		$columns = array();

		// Checkbox Column
		$columns[] = ['class' => CheckboxColumn::class];

	    // Key Column
		$columns[] = [
			'attribute' => 'key',
			'format' => 'html',
			'hAlign' => 'center',
			'value' => function ($model) {
				$url = urldecode(Url::toRoute(['/dictionary/keys/update',
					'id' => $model->id
				]));
				return Html::a($model->key,$url);
			}
		];

		// Translation Columns
		foreach (Yii::$app->controller->module->languages as $langTag) {
			$columns[] = [
				'label' => $langTag,
				'hAlign' => 'center',
				'value' => function ($model) use ($langTag) {
					/** @var Keys $model */
					$lang = substr($langTag,0,2);
					return $model->getTranslationValue($lang);
				}
			];
		}

		// ID Column
	    $columns[] = [
		    'attribute' => 'id',
		    'width' => '6%',
		    'hAlign' => 'center',
	    ];

		return $columns;
    }

	/**
	 * Return action send button
	 *
	 * @param array $url
	 *
	 * @return string
	 */
	public function getDownloadButton(array $url = ['downloadplist'])
	{
		return $this->getStandardButton('fa fa-download text-blue', Yii::t('dictionary','Download as Plist'), $url, ['class' => 'btn btn-mini btn-send']);
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
