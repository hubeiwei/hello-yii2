<?php

namespace app\models\search;

use app\common\helpers\UserHelper;
use app\models\Article;
use app\models\User;
use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
{
    const SCENARIO_INDEX = 'index';
    const SCENARIO_MY_ARTICLE = 'my_article';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by'], 'integer'],
            [['title', 'published_at', 'content', 'visible', 'type', 'status', 'created_at', 'updated_at', 'username'], 'safe'],
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
            'username' => '作者',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $baseAttributes = ['title', 'content', 'username', 'published_at'];
        return array_merge(parent::scenarios(), [
            self::SCENARIO_INDEX => $baseAttributes,
            self::SCENARIO_MY_ARTICLE => array_merge(
                $baseAttributes,
                ['visible', 'type', 'status', 'created_at', 'updated_at']
            ),
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
            ->alias('article')
            ->select([
                'article.*',
                'user.username',
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = article.created_by');

        if ($this->scenario == self::SCENARIO_INDEX) {
            $query->andWhere([
                'visible' => Article::VISIBLE_YES,
                'article.status' => Article::STATUS_ENABLE,
            ]);
            $query->andWhere(['<=', 'published_at', time()]);
        }

        if ($this->scenario == self::SCENARIO_MY_ARTICLE) {
            $query->andWhere(['created_by' => UserHelper::getUserId()]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $this->created_by,
            'type' => $this->type,
            'visible' => $this->visible,
            'article.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('username')]);

        $query->timeRangeFilter('published_at', $this->published_at)
            ->timeRangeFilter('article.created_at', $this->created_at)
            ->timeRangeFilter('article.updated_at', $this->updated_at);

        return $dataProvider;
    }
}
