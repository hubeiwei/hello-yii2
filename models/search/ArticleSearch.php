<?php

namespace app\models\search;

use app\models\Article;
use app\models\User;
use app\modules\core\helpers\UserHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArticleSearch represents the model behind the search form about `app\models\Article`.
 */
class ArticleSearch extends Article
{
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
            ->from(['article' => self::tableName()])
            ->select([
                'article.id',
                'title',
                'created_by',
                'published_at',
                'content',
                'visible',
                'type',
                'article.status',
                'article.created_at',
                'article.updated_at',
                'user.username',
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = article.created_by');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'id' => $this->id,
            'created_by' => $this->created_by,
            'type' => $this->type,
            'visible' => $this->visible,
            'article.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('username')]);

        $query->timeRangeFilter('published_at', $this->published_at);
        $query->timeRangeFilter('article.created_at', $this->created_at);
        $query->timeRangeFilter('article.updated_at', $this->updated_at);

        return $dataProvider;
    }

    public function searchMyArticle($params)
    {
        $query = self::find()->where(['created_by' => UserHelper::getUserId()]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'id' => $this->id,
            'type' => $this->type,
            'visible' => $this->visible,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        $query->timeRangeFilter('published_at', $this->published_at);
        $query->timeRangeFilter('created_at', $this->created_at);
        $query->timeRangeFilter('updated_at', $this->updated_at);

        return $dataProvider;
    }
}
