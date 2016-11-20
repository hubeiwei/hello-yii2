<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/9/20
 * Time: 23:03
 */

namespace app\modules\core\widgets;

use kartik\daterange\DateRangePicker as KartikDateRangePicker;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class DateRangePicker extends KartikDateRangePicker
{
    public $convertFormat = true;

    /**
     * @var bool pluginOptions为空时根据改属性来设置时间格式
     */
    private $_dateOnly = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->pluginOptions)) {
            if ($this->_dateOnly === false) {
                $this->pluginOptions['locale']['format'] = 'Y/m/d H:i:s';
                $this->pluginOptions += [
                    'timePicker' => true,
                    'timePicker24Hour' => true,
                    'timePickerIncrement' => 1,
                    'timePickerSeconds' => true,
                ];
            } else {
                $this->pluginOptions['locale']['format'] = 'Y/m/d';
            }
        }
        $this->pluginOptions['showDropdowns'] = true;
        $this->pluginOptions['locale']['separator'] = ' - ';
        parent::run();
    }

    /**
     * @inheritdoc
     */
    protected function initLocale()
    {
        parent::initLocale();
        $this->setLanguage('', Yii::getAlias('@vendor/kartik-v/yii2-date-range/assets/'));
    }

    public function setDateOnly($value)
    {
        $this->_dateOnly = $value;
    }

    public function getDateOnly()
    {
        return $this->_dateOnly;
    }
}
