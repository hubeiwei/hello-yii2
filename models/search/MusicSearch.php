<?php

namespace app\models\search;

use app\models\Music;
use app\models\User;
use app\modules\core\helpers\UserHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MusicSearch represents the model behind the search form about `app\models\Music`.
 */
class MusicSearch extends Music
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'track_title', 'visible', 'status', 'created_at', 'updated_at', 'user.username'], 'safe'],
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
        $query = Music::find()->joinWith('user');

        if (!UserHelper::userIsAdmin()) {
            $query->where(['visible' => self::VISIBLE_YES, self::tableName() . '.status' => self::STATUS_ENABLE]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'visible' => $this->visible,
            self::tableName() . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'track_title', $this->track_title])
            ->andFilterWhere(['like', User::tableName() . '.username', $this->getAttribute('user.username')]);

        $query->compare('id', $this->id)
            ->compare(self::tableName() . '.user_id', $this->user_id);

        $query->timeRangeFilter(self::tableName() . '.created_at', $this->created_at, false)
            ->timeRangeFilter(self::tableName() . '.updated_at', $this->updated_at, false);

        return $dataProvider;
    }

    public function searchMyMusic($params)
    {
        $query = Music::find()->where(['user_id' => UserHelper::getUserId()]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'visible' => $this->visible,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'track_title', $this->track_title]);

        $query->compare('id', $this->id);

        $query->timeRangeFilter('created_at', $this->created_at, false);
        $query->timeRangeFilter('updated_at', $this->updated_at, false);

        return $dataProvider;
    }
}
