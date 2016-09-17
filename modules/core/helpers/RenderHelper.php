<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 22:30
 * To change this template use File | Setting | File Templates.
 */

namespace app\modules\core\helpers;

use app\modules\core\extensions\HuExportMenu;
use app\modules\core\extensions\HuGridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;

class RenderHelper
{
    /**
     * 表格用到的，筛选枚举类字段的下拉框
     *
     * @param string $name 格式为'ModelSearch[attributeName]'
     * @param string $value
     * @param array $list 形如[value1 => label1, value2 => label2]的数组
     * @return string
     */
    public static function dropDownFilter($name, $value, $list)
    {
        return Html::dropDownList($name, $value, ['' => '全部'] + $list, ['class' => 'form-control', 'style' => ['min-width' => '100px']]);
    }

    /**
     * 表格用到的，筛选日期范围
     *
     * @param $searchModel
     * @param $attribute
     * @param bool $dateOnly
     * @return string
     * @throws \Exception
     */
    public static function dateRangePicker($searchModel, $attribute, $dateOnly = true)
    {
        $setting = [
            'model' => $searchModel,
            'attribute' => $attribute,
            'convertFormat' => true,
            'pluginOptions' => [
                'showDropdowns' => true,
                'locale' => [
                    'separator' => ' - ',
                ]
            ],
        ];

        if ($dateOnly) {
            $setting['pluginOptions']['locale']['format'] = 'Y/m/d';
        } else {
            $setting['pluginOptions']['locale']['format'] = 'Y/m/d H:i:s';
            $setting['pluginOptions'] += [
                'timePicker' => true,
                'timePicker24Hour' => true,
                'timePickerIncrement' => 1,
                'timePickerSeconds' => true,
            ];
        }

        return DateRangePicker::widget($setting);
    }

    /**
     * @param $dataProvider
     * @param $searchModel
     * @param $gridColumns
     * @param bool $hasExport
     * @param bool $hasToolbar
     * @return string
     * @throws \Exception
     */
    public static function gridView($dataProvider, $searchModel, $gridColumns, $hasExport = false, $hasToolbar = false)
    {
        $config = [
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
        ];

        $data = '';

        //ExportMenu
        if ($hasExport) {
            $data .= '<p>';
            $data .= HuExportMenu::widget($config);
            $data .= '</p>';
        }

        $gridConfig = $config + ['filterModel' => $searchModel];
        if ($hasToolbar) {
            $gridConfig += ['layout' => '<p>{toolbar}</p>{summary}{items}{pager}'];
        }

        //GridView
        $data .= HuGridView::widget($gridConfig);

        return $data;
    }
}
