<?php

namespace app\models\search;

use app\models\Music;
use app\models\User;
use app\modules\core\helpers\UserHelper;
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
            [['id', 'user_id', 'track_title', 'visible', 'status', 'created_at', 'updated_at', 'username'], 'safe'],
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
            'username' => '上传者',
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
        /** @var \app\modules\core\extensions\ActiveQuery $query */
        $query = self::find()
            ->from(['music' => self::tableName()])
            ->select([
                'music.*',
                'user.username',
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = music.user_id');

        if (!UserHelper::isAdmin()) {
            $query->where(['visible' => self::VISIBLE_YES, 'music.status' => self::STATUS_ENABLE]);
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
            'music.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'track_title', $this->track_title])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('username')]);

        $query->compare('music.id', $this->id)
            ->compare('user_id', $this->user_id);

        $query->timeRangeFilter('music.created_at', $this->created_at, false)
            ->timeRangeFilter('music.updated_at', $this->updated_at, false);

        return $dataProvider;
    }

    public function searchMyMusic($params)
    {
        /** @var \app\modules\core\extensions\ActiveQuery $query */
        $query = self::find()->where(['user_id' => UserHelper::getUserId()]);

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

        $query->timeRangeFilter('created_at', $this->created_at, false)
            ->timeRangeFilter('updated_at', $this->updated_at, false);

        return $dataProvider;
    }
}
