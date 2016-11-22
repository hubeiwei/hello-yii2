<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 23:28
 * To change this template use File | Setting | File Templates.
 */

namespace app\common\extensions;

use yii\db\ActiveRecord as YiiActiveRecord;

class ActiveRecord extends YiiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
//    public static function findOne($condition, $cache = null)
//    {
//        if ($cache) {
//            return static::findByCondition($condition)->cache($cache)->one();
//        } else {
//            return static::findByCondition($condition)->one();
//        }
//    }

    /**
     * @param array $attribute
     * @return array
     */
    public function getAttributeLabels($attribute)
    {
        $labels = [];
        foreach ($attribute as $value) {
            $labels[$value] = $this->attributeLabels()[$value];
        }
        return $labels;
    }

    /**
     * @param array|null $names
     * @param array $except
     * @return array
     */
    public function getAttributes($names = null, $except = [])
    {
        $values = [];
        if ($names === null) {
            $names = $this->attributes();
        }
        foreach ($names as $name) {
            $values[$name] = (string)$this->$name;
        }
        foreach ($except as $name) {
            unset($values[$name]);
        }

        return $values;
    }

    public function truncateTable()
    {
        return \Yii::$app->db->createCommand()->truncateTable($this->tableName())->execute();
    }

    public function getFirstErrorString()
    {
        if ($this->hasErrors()) {
            return array_values($this->getErrors())[0][0];
        }
        return '';
    }
}
