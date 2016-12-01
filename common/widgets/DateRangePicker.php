<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/9/20
 * Time: 23:03
 */

namespace app\common\widgets;

use kartik\daterange\DateRangePicker as KartikDateRangePicker;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class DateRangePicker extends KartikDateRangePicker
{
    public $convertFormat = true;

    public $presetDropdown = true;

    /**
     * @var bool pluginOptions为空时根据该属性来设置时间格式
     */
    public $dateOnly = false;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->pluginOptions)) {
            if ($this->dateOnly === false) {
                $this->pluginOptions = [
                    'timePicker' => true,
                    'timePicker24Hour' => true,
                    'timePickerIncrement' => 1,
                    'timePickerSeconds' => true,
                    'locale' => [
                        'format' => 'Y/m/d H:i:s',
                    ],
                ];
            } else {
                $this->pluginOptions = [
                    'locale' => [
                        'format' => 'Y/m/d',
                    ],
                ];
            }
        }
        $this->pluginOptions = ArrayHelper::merge(
            $this->pluginOptions,
            [
                'showDropdowns' => true,
                'opens' => 'left',
                'locale' => [
                    'separator' => ' - ',
                ],
            ]
        );
        parent::run();
    }

    /**
     * @inheritdoc
     */
    protected function initLocale()
    {
        // 重写该方法只是为了在第一行代码处指定资源路径，其他不变
        $this->setLanguage('', Yii::getAlias('@kartik/daterange/assets'));
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
}
