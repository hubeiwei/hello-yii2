<?php

namespace app\models\search;

use app\models\User;
use app\models\UserDetail;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserDetailSearch represents the model behind the search form about `app\models\UserDetail`.
 */
class UserDetailSearch extends UserDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'birthday', 'gender', 'phone', 'resume', 'updated_at', 'username'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'username',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'username' => '用户名',
        ]);
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
        $query = self::find()
            ->from(['detail' => self::tableName()])
            ->select([
                'detail.id',
                'detail.user_id',
                'birthday',
                'gender',
                'phone',
                'resume',
                'detail.updated_at',
                'user.username'
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = detail.user_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'resume', $this->resume])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('username')]);

        $query->compare('detail.id', $this->id);
        $query->compare('detail.user_id', $this->user_id);

        $query->timeRangeFilter('birthday', $this->birthday);
        $query->timeRangeFilter('detail.updated_at', $this->updated_at);

        return $dataProvider;
    }
}
