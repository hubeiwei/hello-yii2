<?php

namespace app\models\search;

use Yii;
use app\models\Music;
use app\models\User;
use app\modules\core\helpers\UserHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MusicSearch represents the model behind the search form about `app\models\Music`.
 *
 * 这里遇到user.xx时，会去寻找getUser这个方法，然后在那个方法里返回对应的值就好了，怎么写都行，
 * 我封装在父类Music里面了，以后不一定只在Search类里面用到
 * @see Music::getUser()
 * 其实不一定要叫user，总之我调用xx.oo就会去找getXx()这个方法
 * @see yii\base\Object::__get()
 * 但还是建议写成表名，在网站配置那里遇到了问题
 * @see SettingSearch::attributes()
 * 这个套路在框架源码里能遇到挺多的，你知道可以这样用就好了，我只在关联查询上用过，其他地方暂时还没点子
 */
class MusicSearch extends Music
{
    /**
     * 这里不仅仅是规则
     * 还可以理解为在这设置了字段的后
     * 表格里对应字段上会有用来搜索的文本框
     * 也包括在URL上搜索（随便搜一个字段，然后看看URL的格式）
     * 不用担心visible和status能被普通用户在url上搜索到，下面有讲
     *
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
        /**
         * 没进行任何搜索的时候，with和joinWith的语句是一样的，但是搜索和排序的时候就不一样了，可以自己改改下面的体验一下
         * 试试用不同用户都添加几个音乐，再把with或者joinWith删掉，去debug工具条看看跑了多少条语句
         *
         * @see SettingSearch::search() 也可以来这里看看left_join
         */
        $query = Music::find()->joinWith('user')/*->with('user')*/;

        //普通用户只能看到visible和status为Y的数据，下面会讲到Filter
        if (!UserHelper::userIsAdmin()) {
            /**
             * tableName()方法下面有讲到
             */
            $query->where(['visible' => self::VISIBLE_YES, self::tableName() . '.status' => self::STATUS_ENABLE]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //分页
            'pagination' => [
                'pageSize' => 10,
            ],
            //数据表格的默认排序，当然也可以在上面的Model::find()->orderBy('字段名')直接对查询出来的数据进行排序
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /**
         * 以下的Filter顾名思义，搜索后对上面已经查询出来的数据进行过滤，对一些复杂的查询也可以尝试这样用
         * 有些字段改成'表名.字段名'，用Model::tableName()拼接的好处是，你以后改了表名，只需在Model里修改就好了，
         * 而且这个tableName()的方法也决定了你的Model查询数据时是往哪个表查，从而可以随意取Model的名字，
         * @see Music::tableName()
         * @see User::tableName()
         * 但还是根据规范还是用gii生成的Model名最好，因为你不写tableName()方法的话会用你的Model名当作表名来查询。
         * @see ActiveRecord::tableName()
         */

        // grid filtering conditions
        $query->andFilterWhere([
            'visible' => $this->visible,
            self::tableName() . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'track_title', $this->track_title])
            ->andFilterWhere(['like', User::tableName() . '.username', $this->getAttribute('user.username')]);

        //在别人项目抠过来的，这个方法可以实现在表格用类似[>1]和[>2 <=5]之类的方法搜索，还没具体用到的字段，所以先用在id吧
        $query->compare('id', $this->id)
            ->compare(self::tableName() . '.user_id', $this->user_id);

        //在别人项目抠过来的，按时间范围筛选数据
        $query->timeFilterRange(self::tableName() . '.created_at', $this->created_at, false)
            ->timeFilterRange(self::tableName() . '.updated_at', $this->updated_at, false);

        return $dataProvider;
    }

    public function searchMyMusic($params)
    {
        $query = Music::find()->where(['user_id' => UserHelper::getUserId()]);//只看当前用户的

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider();

        //这里分页排序什么的和上面一个套路
        $dataProvider->query = $query;
        $dataProvider->pagination = [
            'pageSize' => 10,
        ];
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC],
        ];

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

        $query->timeFilterRange('created_at', $this->created_at, false);
        $query->timeFilterRange('updated_at', $this->updated_at, false);

        return $dataProvider;
    }
}
