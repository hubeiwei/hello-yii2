<?php

namespace app\models\search;

use app\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username', 'email', 'status', 'created_at', 'updated_at'], 'safe'],
        ];
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
        /** @var \hubeiwei\yii2tools\extensions\ActiveQuery $query */
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        $query->compare('id', $this->id);

        $query->timeRangeFilter('created_at', $this->created_at)
            ->timeRangeFilter('updated_at', $this->updated_at);

        return $dataProvider;
    }
}
