<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 22:30
 * To change this template use File | Setting | File Templates.
 */

namespace app\modules\core\helpers;

use app\modules\core\widgets\ExportMenu;
use app\modules\core\widgets\GridView;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Yii;

class RenderHelper
{
    /**
     * 表格用到的，筛选枚举类字段的下拉框
     *
     * @param Model $model
     * @param string $attribute
     * @param array $list 形如[value1 => label1, value2 => label2]的数组
     * @return null|string
     */
    public static function dropDownFilter($model, $attribute, $list)
    {
        if ($model instanceof Model) {
            return Html::dropDownList($model->formName() . '[' . $attribute . ']', $model->$attribute, ['' => '全部'] + $list, ['class' => 'form-control', 'style' => ['min-width' => '100px']]);
        } else {
            return null;
        }
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

        $export = !$hasExport ? '' : ExportMenu::widget(ArrayHelper::merge($config, [
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_EXCEL => false,
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
//            'showPageSummary' => true,
        ]);
        if ($searchModel !== null) {
            $gridConfig['filterModel'] = $searchModel;
        }
        $gridConfig['layout'] = '<p>' . $resetUrl . '{toolbar}' . $export . '</p>{summary}{items}{pager}';

        return GridView::widget($gridConfig);
    }
}
