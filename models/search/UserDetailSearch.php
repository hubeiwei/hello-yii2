<?php

namespace app\models\search;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserDetail;

/**
 * UserDetailSearch represents the model behind the search form about `app\models\UserDetail`.
 */
class UserDetailSearch extends UserDetail
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'user.username',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'birthday', 'gender', 'email', 'phone', 'resume', 'security_question', 'security_answer', 'updated_at', 'user.username'], 'safe'],
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
        $query = UserDetail::find()->with('user');

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
        $query->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'resume', $this->resume])
            ->andFilterWhere(['like', 'security_question', $this->security_question])
            ->andFilterWhere(['like', 'security_answer', $this->security_answer])
            ->andFilterWhere(['like', User::tableName() . 'username', $this->getAttribute('user.username')]);

        $query->compare('id', $this->id);
        $query->compare('user_id', $this->user_id);

        $query->timeRangeFilter('birthday', $this->birthday);
        $query->timeRangeFilter('updated_at', $this->updated_at);

        return $dataProvider;
    }
}
