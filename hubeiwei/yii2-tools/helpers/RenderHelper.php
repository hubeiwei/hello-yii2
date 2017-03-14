<?php

namespace hubeiwei\yii2tools\helpers;

use hubeiwei\yii2tools\grid\ExportMenu;
use hubeiwei\yii2tools\grid\GridView;
use kartik\dynagrid\DynaGrid;
use liyunfang\pager\LinkPager;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RenderHelper
{
    /**
     * GridView 枚举类字段搜索用到下拉框
     * 使用 DynaGrid 的默认过滤时不会选中，需要使用 Select2
     * @see \hubeiwei\yii2tools\widgets\Select2
     *
     * @param Model $model
     * @param string $attribute
     * @param array $map
     * @param array $options
     * @return null|string
     */
    public static function dropDownFilter($model, $attribute, $map, $options = [])
    {
        if ($model instanceof Model) {
            $options = ArrayHelper::merge(
                [
                    'class' => ['form-control'],
                    'style' => ['min-width' => '120px'],
                ],
                $options
            );
            return Html::dropDownList(
                $model->formName() . '[' . $attribute . ']',
                $model->$attribute,
                ['' => '全部'] + $map,
                $options
            );
        } else {
            return null;
        }
    }

    /**
     * 根据业务来封装的 GridView
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
            'filterSelector' => "input[name='" . $dataProvider->getPagination()->pageParam . "']",
            'pager' => [
                'class' => LinkPager::className(),
                'template' => '<div class="form-inline" style="padding: 10px 0 0;">{pageButtons}{customPage}</div>',
                'options' => [
                    'class' => ['pagination'],
                    'style' => [
                        'margin' => 0,
                        'float' => 'left',
                    ],
                ],
            ],
        ]);
        if ($searchModel !== null) {
            $gridConfig['filterModel'] = $searchModel;
        }

        return GridView::widget($gridConfig);
    }

    /**
     * 根据业务来封装的 DynaGrid
     * DynaGrid 的模块配置可以参考我的：
     * @link https://github.com/hubeiwei/hello-yii2/blob/master/config/modules.php#L40
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
