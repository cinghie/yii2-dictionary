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

/**
 * This is the ActiveQuery class for [[Keys]].
 *
 * @see Keys
 */
class KeysQuery extends \yii\db\ActiveQuery
{
	/**
	 * {@inheritdoc}
	 *
	 * @return KeysQuery
	 */
    public function findByKey($key)
    {
    	$condition = '[[key]]= "'.$key.'"';

        return $this->andWhere($condition)->one();
    }

    /**
     * {@inheritdoc}
     *
     * @return Keys[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     *
     * @return Keys|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
