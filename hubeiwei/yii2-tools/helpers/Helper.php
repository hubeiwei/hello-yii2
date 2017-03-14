<?php

namespace hubeiwei\yii2tools\helpers;

use Yii;
use yii\db\Transaction;

class Helper
{
    /**
     * 开启事务
     *
     * 该方法只是为了让不同数据库的 component 开启事务时都能让 IDE 提示代码
     *
     * @param \yii\db\Connection $db
     * @param string $isolationLevel
     * @return Transaction
     */
    public static function beginTransaction($db = null, $isolationLevel = Transaction::SERIALIZABLE)
    {
        if ($db === null) {
            $db = Yii::$app->getDb();
        }
        return $db->beginTransaction($isolationLevel);
    }

    /**
     * @param $value
     * @return string|array
     */
    public static function unifyLimiter($value)
    {
        return str_replace([' ', '　', '，', '、', '
'], ',', $value);// 不要取消换行！那是 newline
    }
}
