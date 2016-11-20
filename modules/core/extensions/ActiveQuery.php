<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 23:35
 * To change this template use File | Setting | File Templates.
 */

namespace app\modules\core\extensions;

use app\modules\core\helpers\EasyHelper;
use yii\db\ActiveQuery as YiiActiveQuery;

class ActiveQuery extends YiiActiveQuery
{
    /**
     * @param string $attribute
     *
     * @param string $conditionString
     * 条件语句类似">1,<3"或">1 <3"，如果输入">1, <3"会被转换成">1,,<3"，这也没关系，
     * 如果你有阅读源码的习惯，你应该能看到有一个return被注释掉，用continue取代它了，测试了一下是没有问题的，如果有问题的话就提出吧
     * @see EasyHelper::unifyLimiter()
     *
     * @return $this
     */
    public function compare($attribute, $conditionString)
    {
        $value = '';

        $conditionString = "$conditionString";
        $conditions = explode(',', EasyHelper::unifyLimiter($conditionString));
        foreach ($conditions as $condition) {
            if (preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/', $condition, $matches)) {
                $value = $matches[2];
                $op = $matches[1];
            } else {
                $op = '';
            }

            if ($value === '') {
                continue;
            }

            if ($op === '') {
                $op = '=';
            }

            $this->andFilterWhere([$op, $attribute, $value]);
        }

        return $this;
    }

    /**
     * @see \app\modules\core\widgets\DateRangePicker
     *
     * @param string $attribute
     * @param string $value
     * @param bool $date_only
     * @return $this
     */
    public function timeRangeFilter($attribute, $value, $date_only = true)
    {
        if ($value != '') {
            $value = "$value";
            $conditions = explode('-', $value);

            $from = strtotime(trim($conditions[0]));
            if (!$from || !isset($conditions[1])) {
                return $this;
            }

            if ($date_only) {
                $to = strtotime(trim($conditions[1])) + 24 * 60 * 60;
            } else {
                $to = strtotime(trim($conditions[1]));
            }

            if (isset($conditions[0]) && isset($conditions[1])) {
                $this->andFilterWhere(['between', $attribute, $from, $to]);
            }
        }
        return $this;
    }
}
