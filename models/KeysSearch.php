<?php

namespace cinghie\dictionary\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * KeysSearch represents the model behind the search form of `cinghie\dictionary\models\Keys`.
 */
class KeysSearch extends Keys
{
	public $langTag;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	$rules = [
		    [['id'], 'integer'],
		    [['key'], 'safe'],
	    ];

	    foreach (Yii::$app->controller->module->languages as $langTag) {
		    $rules[] = [[$langTag], 'safe'];
	    }

        return $rules;
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
	    $query->joinWith('values');

	    $dataProvider = new ActiveDataProvider([
		    'query' => $query,
		    'sort' => [
			    'defaultOrder' => [
				    'id' => SORT_DESC
			    ],
		    ],
	    ]);

	    foreach (Yii::$app->controller->module->languages as $langTag)
	    {
		    $dataProvider->sort->attributes['lang_tag'] = [
			    'asc' => ['lang_tag' => SORT_ASC],
			    'desc' => ['lang_tag' => SORT_DESC],
		    ];
	    }

	    $this->load($params);

	    if (!$this->validate()) {
		    // uncomment the following line if you do not want to return any records when validation fails
		    // $query->where('0=1');
		    return $dataProvider;
	    }

	    foreach (Yii::$app->controller->module->languages as $langTag)
	    {
		    if(isset($this->$langTag) && $this->$langTag !== '') {
			    $query->andFilterWhere(['{{%dictionary_values}}.lang_tag' => $this->$langTag]);
		    }
	    }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
