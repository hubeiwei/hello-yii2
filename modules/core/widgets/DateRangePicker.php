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
        $this->setLanguage('', Yii::getAlias('@vendor/kartik-v/yii2-date-range/assets/'));// 复写该方法是为了在此处加上了第二个路径参数，其他不变
        if (empty($this->_langFile)) {
            return;
        }
        $localeSettings = ArrayHelper::getValue($this->pluginOptions, 'locale', []);
        $localeSettings += [
            'applyLabel' => Yii::t('kvdrp', 'Apply'),
            'cancelLabel' => Yii::t('kvdrp', 'Cancel'),
            'fromLabel' => Yii::t('kvdrp', 'From'),
            'toLabel' => Yii::t('kvdrp', 'To'),
            'weekLabel' => Yii::t('kvdrp', 'W'),
            'customRangeLabel' => Yii::t('kvdrp', 'Custom Range'),
            'daysOfWeek' => new JsExpression('moment.weekdaysMin()'),
            'monthNames' => new JsExpression('moment.monthsShort()'),
            'firstDay' => new JsExpression('moment.localeData()._week.dow')
        ];
        $this->pluginOptions['locale'] = $localeSettings;
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
