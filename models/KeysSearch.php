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

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * KeysSearch represents the model behind the search form of `cinghie\dictionary\models\Keys`.
 */
class KeysSearch extends Keys
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
	        [['id'], 'integer'],
	        [['key'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Keys::find();

	    $dataProvider = new ActiveDataProvider([
		    'query' => $query,
		    'sort' => [
			    'defaultOrder' => [
				    'id' => SORT_DESC
			    ],
		    ],
	    ]);

	    $this->load($params);

	    if (!$this->validate()) {
		    // uncomment the following line if you do not want to return any records when validation fails
		    // $query->where('0=1');
		    return $dataProvider;
	    }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
