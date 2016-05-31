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
use yii\db\ActiveQuery;
use yii\db\Command;

class HuActiveQuery extends ActiveQuery
{
    public function compare($column, $raw)
    {
        $raw = "$raw";
        $conditions = explode(',', EasyHelper::unifyLimiter($raw));

        foreach ($conditions as $condition) {
            if (preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/', $condition, $matches)) {
                $value = $matches[2];
                $op = $matches[1];
            } else
                $op = '';

            if ($value === '')
                return $this;

            if ($op === '')
                $op = '=';

            $this->andFilterWhere([$op, $column, $value]);
        }

        return $this;
    }

    /**
     * @param $column
     * @param $raw
     * @param bool $date_only
     * @return $this
     */
    public function timeFilterRange($column, $raw, $date_only = true)
    {
        if ($raw != '') {
            $raw = "$raw";
            $conditions = explode('-', $raw);

            $from = strtotime(trim($conditions[0]));
            if (!$from || !isset($conditions[1])) {
                return false;
            }

            if ($date_only) {
                $to = strtotime(trim($conditions[1])) + 60 * 60 * 24;
            } else {
                $to = strtotime(trim($conditions[1]));
            }

            if (isset($conditions[0]) && isset($conditions[1])) {
                $this->andFilterWhere(['between', $column, $from, $to]);
            }
        }
        return $this;
    }
}
