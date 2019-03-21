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
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dictionary_values}}".
 *
 * @property int $id
 * @property int $key_id
 * @property string $value
 * @property string $lang
 * @property string $lang_tag
 *
 * @property Keys $key
 */
class Values extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dictionary_values}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key_id'], 'integer'],
            [['lang', 'lang_tag'], 'required'],
            [['lang'], 'string', 'max' => 2],
            [['lang_tag'], 'string', 'max' => 5],
            [['value'], 'string', 'max' => 255],
            [['key_id'], 'exist', 'skipOnError' => true, 'targetClass' => Keys::class, 'targetAttribute' => ['key_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('traits', 'ID'),
            'key_id' => Yii::t('traits', 'Key'),
            'value' => Yii::t('traits', 'Value'),
            'lang' => Yii::t('traits', 'Language'),
            'lang_tag' => Yii::t('traits', 'Language Tag'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getKey()
    {
        return $this->hasOne(Keys::class, ['id' => 'key_id']);
    }

    /**
     * {@inheritdoc}
     *
     * @return ValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ValuesQuery( static::class );
    }
}
