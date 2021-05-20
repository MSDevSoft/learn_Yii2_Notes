<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientCompany;

/**
 * ClientCompanySearch represents the model behind the search form of `app\models\ClientCompany`.
 */
class ClientCompanySearch extends ClientCompany
{
    /**
     * ###!!!
     * Wymagane dodanie pól do wartości safe
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'person_id'], 'integer'],
            [['company_name', 'user_name', 'created_at'], 'safe'],
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
        $query = ClientCompany::find();

        // add conditions that should always apply here

        ###!!! paginacja
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2
            ]
        ]);

        ###!!! sortowanie po dodanych polach
        $dataProvider->sort->attributes['user_name'] = [
            'asc' => ['user.user_name' => SORT_ASC],
            'desc' => ['user.user_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['person_id'] = [
            'asc' => ['person.person_name' => SORT_ASC],
            'desc' => ['person.person_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        ###!!! Wymagane dodanie relacji
        $query->joinWith('person');
        $query->joinWith('user');

        ###!!! Jeżeli chciałbym szukać po select to dodaję jako where, a nie like
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
        ]);

        ###!!! wymagane filtrowanie po like
        $query->andFilterWhere(['like', 'company_name', $this->company_name]);
        $query->andFilterWhere(['like', 'person.id', $this->person_id]);
        $query->andFilterWhere(['like', 'user.user_name', $this->user_name]);

        return $dataProvider;
    }
}
