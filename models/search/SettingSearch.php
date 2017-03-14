<?php

namespace app\models\search;

use app\models\Setting;
use app\models\User;
use yii\data\ActiveDataProvider;

class SettingSearch extends Setting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'key', 'value', 'status', 'description', 'tag', 'updated_by', 'created_at', 'updated_at', 'username'], 'safe'],
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
            'username' => '操作人',
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
        /** @var \hubeiwei\yii2tools\extensions\ActiveQuery $query */
        $query = self::find()
            ->alias('setting')
            ->select([
                'setting.*',
                'user.username',
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = setting.updated_by');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'setting.id' => $this->id,
            'setting.updated_by' => $this->updated_by,
            'user.username' => $this->getAttribute('username'),
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'setting.status', $this->status])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'tag', $this->tag]);

        $query->timeRangeFilter('setting.created_at', $this->created_at)
            ->timeRangeFilter('setting.updated_at', $this->updated_at);

        return $dataProvider;
    }
}
