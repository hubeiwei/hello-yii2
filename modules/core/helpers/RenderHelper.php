<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 22:30
 * To change this template use File | Setting | File Templates.
 */

namespace app\modules\core\helpers;

use app\modules\core\widget\HuExportMenu;
use app\modules\core\widget\HuGridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Yii;

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
     * @param $dataProvider
     * @param $gridColumns
     * @param $searchModel
     * @param bool $hasExport
     * @return string
     * @throws \Exception
     */
    public static function gridView($dataProvider, $gridColumns, $searchModel = null, $hasExport = false)
    {
        $config = [
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
        ];

        $resetUrl = '<div class="btn-group">' . Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置', [Yii::$app->controller->action->id], ['class' => 'btn btn-default', 'title' => '重置搜索条件', 'data' => ['pjax' => 'true']]) . '</div>';

        $export = !$hasExport ? '' : HuExportMenu::widget(ArrayHelper::merge($config, [
            'exportConfig' => [
                HuExportMenu::FORMAT_HTML => false,
                HuExportMenu::FORMAT_TEXT => false,
                HuExportMenu::FORMAT_PDF => false,
                HuExportMenu::FORMAT_EXCEL => false,
            ],
            'pjaxContainerId' => 'kartik-grid-pjax',
        ]));

        $gridConfig = ArrayHelper::merge($config, [
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'id' => 'kartik-grid-pjax',
                ],
            ],
        ]);
        if ($searchModel !== null) {
            $gridConfig['filterModel'] = $searchModel;
        }
        $gridConfig['layout'] = '<p>' . $resetUrl . '{toolbar}' . $export . '</p>{summary}{items}{pager}';

        return HuGridView::widget($gridConfig);
    }
}
