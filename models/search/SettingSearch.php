<?php

namespace app\models\search;

use app\models\Setting;
use app\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SettingSearch represents the model behind the search form about `app\models\Setting`.
 */
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
        /** @var \app\common\extensions\ActiveQuery $query */
        $query = self::find()
            ->from(['setting' => self::tableName()])
            ->select([
                'setting.*',
                'user.username',
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = setting.updated_by');

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
            'setting.id' => $this->id,
            'setting.updated_by' => $this->updated_by,
            'user.username' => $this->getAttribute('username'),
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'setting.status', $this->status])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'tag', $this->tag]);

        $query->timeRangeFilter('setting.created_at', $this->created_at, false)
            ->timeRangeFilter('setting.updated_at', $this->updated_at, false);

        return $dataProvider;
    }
}
