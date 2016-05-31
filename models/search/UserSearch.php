<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

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
            [['user_id', 'username'/*, 'password', 'passkey'*/, 'type', 'status'/*, 'auth_key', 'access_token'*/, 'created_at', 'updated_at', 'last_login', 'last_ip'], 'safe'],
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
            'type' => $this->type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
//            ->andFilterWhere(['like', 'password', $this->password])
//            ->andFilterWhere(['like', 'passkey', $this->passkey])
//            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
//            ->andFilterWhere(['like', 'access_token', $this->access_token])
        ;

        $query->compare('user_id', $this->user_id);

        $query->timeFilterRange('created_at', $this->created_at);
        $query->timeFilterRange('updated_at', $this->updated_at);
        $query->timeFilterRange('last_login', $this->last_login);

        return $dataProvider;
    }
}
