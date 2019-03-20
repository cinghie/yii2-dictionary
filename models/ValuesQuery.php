<?php

namespace cinghie\dictionary\models;

/**
 * This is the ActiveQuery class for [[Values]].
 *
 * @see Values
 */
class ValuesQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     *
     * @return Values[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     *
     * @return Values|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
