<?php

namespace app\models\search;

use app\common\helpers\UserHelper;
use app\models\Music;
use app\models\User;
use yii\data\ActiveDataProvider;

class MusicSearch extends Music
{
    const SCENARIO_INDEX = 'index';
    const SCENARIO_MY_MUSIC = 'my_music';

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
        $baseAttributes = ['track_title', 'created_at'];
        return array_merge(parent::scenarios(), [
            self::SCENARIO_INDEX => array_merge(
                $baseAttributes,
                ['username']
            ),
            self::SCENARIO_MY_MUSIC => array_merge(
                $baseAttributes,
                ['visible', 'status', 'updated_at']
            ),
        ]);
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
        /** @var \app\common\extensions\ActiveQuery $query */
        $query = self::find()
            ->from(['music' => self::tableName()])
            ->select([
                'music.*',
                'user.username',
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = music.user_id');

        if ($this->scenario == self::SCENARIO_INDEX && !UserHelper::isAdmin()) {
            $query->andWhere([
                'visible' => self::VISIBLE_YES,
                'music.status' => self::STATUS_ENABLE,
            ]);
        }

        if ($this->scenario == self::SCENARIO_MY_MUSIC) {
            $query->andWhere(['user_id' => UserHelper::getUserId()]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'visible' => $this->visible,
            'music.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'track_title', $this->track_title])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('username')]);

        $query->compare('music.id', $this->id)
            ->compare('user_id', $this->user_id);

        $query->timeRangeFilter('music.created_at', $this->created_at)
            ->timeRangeFilter('music.updated_at', $this->updated_at);

        return $dataProvider;
    }
}
