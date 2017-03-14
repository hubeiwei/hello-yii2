<?php

namespace hubeiwei\yii2tools\extensions;

use hubeiwei\yii2tools\helpers\Helper;

trait QueryTrait
{
    /**
     * @param string $attribute
     *
     * @param string $expression
     * 格式可以是 "1,<2,!=3" 或 "1 <2 !=3"，你看下面给出的方法就明白了
     * @see Helper::unifyLimiter()
     *
     * @return $this
     */
    public function compare($attribute, $expression)
    {
        $value = '';
        $expression = "$expression";
        $conditions = explode(',', Helper::unifyLimiter($expression));
        foreach ($conditions as $condition) {
            if (preg_match('/^(?:\s*(<>|!=|<=|>=|<|>|=))?(.*)$/', $condition, $matches)) {
                $op = $matches[1];
                $value = $matches[2];
            } else {
                $op = '';
            }

            if ($value === '') {
                continue;
//                return $this;
            }

            if ($op === '') {
                $op = '=';
            }

            $this->andFilterWhere([$op, $attribute, $value]);
        }

        return $this;
    }

    /**
     * @see \hubeiwei\yii2tools\widgets\DateRangePicker
     *
     * @param string $attribute
     * @param string $value
     * @param bool $date_only
     * @return $this
     */
    public function timeRangeFilter($attribute, $value, $date_only = false)
    {
        if ($value != '') {
            $value = "$value";
            $conditions = explode('-', $value);

            $from = strtotime(trim($conditions[0]));
            if (!$from || !isset($conditions[1])) {
                return $this;
            }

            if ($date_only) {
                $to = strtotime(trim($conditions[1])) + 24 * 60 * 60 - 1;
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
