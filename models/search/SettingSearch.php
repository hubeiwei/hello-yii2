<?php

namespace app\models\search;

use app\models\Setting;
use app\modules\core\helpers\UserHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SettingSearch represents the model behind the search form about `app\models\Setting`.
 */
class SettingSearch extends Setting
{
    /**
     * 因为"creater.username"和"updater.username"都往user表的username取值，
     * 按"creater.username"排序的时候绝对找不到"creater"这个表，看看sql语句就知道了，"updater.username"也是如此，
     * 我发现把这两个属性设置在SettingSearch里，在表格里就不能排序了。
     * 但搜索也是类似的问题，所以最终我决定把GridColumns里的这两个字段的attribute设置成"created_by"和"updated_by"，
     * 下面的Filter也是牺牲掉了一点性能以及"created_by"、"updated_by"的搜索，详情还是拉下去看吧。
     *
     * TODO 这里暂时先这样吧，我不懂怎么解决这个问题
     *
     * @return array
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'creater.username',
            'updater.username',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'key', 'value', 'status', 'description', 'tag', 'created_by', 'updated_by', 'created_at', 'updated_at', 'creater.username', 'updater.username'], 'safe'],
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
        $query = Setting::find()->with('creater', 'updater');

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

        $created_by = '';
        if ($this->created_by != '') {
            $created_by = UserHelper::getUserId($this->getAttribute('creater.username'));
        }

        $updated_by = '';
        if ($this->updated_by != '') {
            $updated_by = UserHelper::getUserId($this->getAttribute('updater.username'));
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $created_by,
            'updated_by' => $updated_by,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'tag', $this->tag]);

        $query->compare('id', $this->id);

        $query->timeRangeFilter('created_at', $this->created_at, false)
            ->timeRangeFilter('updated_at', $this->updated_at, false);

        return $dataProvider;
    }
}
