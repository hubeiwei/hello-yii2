<?php

namespace app\models\search;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username'/*, 'password', 'passkey'*/, 'status'/*, 'auth_key', 'access_token'*/, 'created_at', 'updated_at', 'last_login', 'last_ip'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
//            ->andFilterWhere(['like', 'password', $this->password])
//            ->andFilterWhere(['like', 'passkey', $this->passkey])
//            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
//            ->andFilterWhere(['like', 'access_token', $this->access_token])
        ;

        $query->compare('user_id', $this->id);

        $query->timeRangeFilter('created_at', $this->created_at);
        $query->timeRangeFilter('updated_at', $this->updated_at);
        $query->timeRangeFilter('last_login', $this->last_login);

        return $dataProvider;
    }
}
