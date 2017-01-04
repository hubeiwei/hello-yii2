<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 22:30
 * To change this template use File | Setting | File Templates.
 */

namespace app\common\helpers;

use app\common\grid\ExportMenu;
use app\common\grid\GridView;
use kartik\dynagrid\DynaGrid;
use liyunfang\pager\LinkPager;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RenderHelper
{
    /**
     * GridView枚举类字段搜索专用下拉框，不支持DynaGrid的默认排序
     *
     * @param Model $model
     * @param string $attribute
     * @param array $list 形如[value1 => label1, value2 => label2]的数组
     * @return null|string
     */
    public static function dropDownFilter($model, $attribute, $list)
    {
        if ($model instanceof Model) {
            return Html::dropDownList($model->formName() . '[' . $attribute . ']', $model->$attribute, ['' => '全部'] + $list, ['class' => 'form-control', 'style' => ['min-width' => '120px']]);
        } else {
            return null;
        }
    }

    /**
     * 根据业务来封装的GridView，部分配置需要到类本身查看
     * @see GridView
     * @see ExportMenu 导出
     *
     * @param $dataProvider \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider|\yii\data\SqlDataProvider
     * @param $gridColumns array
     * @param $searchModel \yii\base\Model
     * @param $hasExport bool
     * @param $showPageSummary bool
     * @return string
     */
    public static function gridView($dataProvider, $gridColumns, $searchModel = null, $hasExport = false, $showPageSummary = false)
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
            'layout' => '<p>{toolbar}</p>{summary}{items}{pager}',
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'id' => 'kartik-grid-pjax',
                ],
            ],
            'showPageSummary' => $showPageSummary,
            'toolbar' => [
                '{toggleData}',
                $resetUrl,
                $export,
            ],
        ]);
        if ($searchModel !== null) {
            $gridConfig['filterModel'] = $searchModel;
        }

        return GridView::widget($gridConfig);
    }

    /**
     * 根据业务来封装的DynaGrid，部分配置需要到`config/modules.php`查看
     * @see ExportMenu 导出
     *
     * @param $id string
     * @param $dataProvider \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider|\yii\data\SqlDataProvider
     * @param $gridColumns array
     * @param $searchModel \yii\base\Model
     * @param $showPageSummary bool
     * @return string
     */
    public static function dynaGrid($id, $dataProvider, $gridColumns, $searchModel = null, $showPageSummary = false)
    {
        $resetUrl = '<div class="btn-group">' . Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置', [Yii::$app->controller->action->id], ['class' => 'btn btn-default', 'title' => '重置搜索条件', 'data' => ['pjax' => 'true']]) . '</div>';

        $export = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_EXCEL => false,
            ],
            'pjaxContainerId' => $id . '-pjax',
        ]);

        $gridConfig = [
            'dataProvider' => $dataProvider,
            'pjax' => true,
            'showPageSummary' => $showPageSummary,
            'toolbar' => [
                '{toggleData}',
                $resetUrl,
                $export,
                ['content' => '{dynagrid}{dynagridFilter}{dynagridSort}'],
            ],
            'filterSelector' => "input[name='" . $dataProvider->getPagination()->pageParam . "']",
            'pager' => [
                'class' => LinkPager::className(),
                'template' => '<div class="form-inline">{pageButtons}{customPage}</div>',
            ],
        ];
        if ($searchModel !== null) {
            $gridConfig['filterModel'] = $searchModel;
        }

        $dynaGridConfig = [
            'allowThemeSetting' => false,
            'gridOptions' => $gridConfig,
            'options' => [
                'id' => $id,
            ],
            'columns' => $gridColumns,
        ];

        return DynaGrid::widget($dynaGridConfig);
    }
}
