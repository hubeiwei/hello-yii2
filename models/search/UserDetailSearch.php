<?php

namespace app\models\search;

use app\models\User;
use app\models\UserDetail;
use yii\data\ActiveDataProvider;

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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /** @var \app\common\extensions\ActiveQuery $query */
        $query = self::find()
            ->alias('detail')
            ->select([
                'detail.*',
                'user.username'
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = detail.user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'resume', $this->resume])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('username')]);

        $query->compare('detail.id', $this->id)
            ->compare('detail.user_id', $this->user_id);

        $query->timeRangeFilter('birthday', $this->birthday, true)
            ->timeRangeFilter('detail.updated_at', $this->updated_at);

        return $dataProvider;
    }
}
