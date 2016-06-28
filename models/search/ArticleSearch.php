<?php

namespace app\models\search;

use app\models\User;
use app\modules\core\helpers\UserHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Article;

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
            [['title', 'published_at', 'content', 'visible', 'type', 'status', 'created_at', 'updated_at', 'user.username'], 'safe'],
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
        $query = self::find()->joinWith('user');

        if (!UserHelper::userIsAdmin()) {
            $query->where(['visible' => self::VISIBLE_YES, self::tableName() . '.status' => self::STATUS_ENABLE]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
//            'pagination' => [
//                'pageSize' => 15,
//            ],
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
            self::tableName() . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', User::tableName() . '.username', $this->getAttribute('user.username')]);

        $query->timeRangeFilter('published_at', $this->published_at);
        $query->timeRangeFilter(self::tableName() . '.created_at', $this->created_at);
        $query->timeRangeFilter(self::tableName() . '.updated_at', $this->updated_at);

        return $dataProvider;
    }

    public function searchMyArticle($params)
    {
        $query = Article::find()->where(['created_by' => UserHelper::getUserId()]);

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
