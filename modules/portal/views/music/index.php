<?php

use app\models\Music;
use app\modules\core\helpers\EasyHelper;
use app\modules\core\helpers\FileHelper;
use app\modules\core\helpers\RenderHelper;
use app\modules\core\helpers\UserHelper;
use kartik\grid\ActionColumn;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel app\models\search\MusicSearch
 */

$this->title = '音乐';
//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

/**
 * 数组里可以直接写字段名
 * 也可以写成['attribute' => '字段名']
 * 还可以写成['attribute' => '字段名', 'value' => '字段名或function']，值以value为准，label以attribute为准
 * 还可以写成['label' => '任意', 'value' => '字段名或function']
 * @see \yii\grid\GridView 详情还是来这里看
 *
 * 配置项可以结合我的代码看下面这两个
 * @see \yii\grid\DataColumn
 * @see \kartik\grid\DataColumn
 */
$gridColumns = [
    ['class' => SerialColumn::className()],

    [
        'attribute' => 'track_title',
        'value' => function ($model) {
            return Html::a($model->track_title, 'javascript:void(0)', [
                'class' => 'play-list-item',
                'style' => [
                    'display' => 'block'
                ],
                'data-music' => $model->music_file,
            ]);
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'user.username',
        'value' => function ($model) {
            return Html::a($model->user['username'], ['index', 'MusicSearch[user_id]' => $model->user_id]);
        },
        'format' => 'html',
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'visible',
        'value' => function ($model) {
            return Music::$visible_map[$model->visible];
        },
        'filter' => RenderHelper::dropDownFilter('MusicSearch[visible]', $searchModel->visible, Music::$visible_map),
        'headerOptions' => ['width' => 100],
        //只有管理员才能看到此列
        'visible' => UserHelper::userIsAdmin(),
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return Music::$status_map[$model->status];
        },
        'filter' => RenderHelper::dropDownFilter('MusicSearch[status]', $searchModel->status, Music::$status_map),
        'headerOptions' => ['width' => 100],
        //只有管理员才能看到此列
        'visible' => UserHelper::userIsAdmin(),
    ],
    [
        'attribute' => 'created_at',
        'value' => function ($model) {
            return EasyHelper::timestampToDate($model->created_at);
        },
        'filter' => RenderHelper::dateRangePicker('MusicSearch[created_at]', false),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'value' => function ($model) {
            return EasyHelper::timestampToDate($model->updated_at);
        },
        'filter' => RenderHelper::dateRangePicker('MusicSearch[updated_at]', false),
        'headerOptions' => ['width' => 160],
        //感觉要这个字段没什么用，只让管理员才能看到吧
        'visible' => UserHelper::userIsAdmin(),
    ],

    [
        'class' => ActionColumn::className(),
        'template' => '{update} {delete}',
        //登录后才显示此列
        'visible' => !UserHelper::userIsGuest(),
        //根据所属者显示按钮
        'visibleButtons' => [
            'update' => function ($model, $key, $index) {
                return UserHelper::isBelongToUser($model->user_id);
            },
            'delete' => function ($model, $key, $index) {
                return UserHelper::isBelongToUser($model->user_id);
            },
        ],
//        'headerOptions' => ['width' => 80],
//        'width' => false,//这是style的width，默认80有效，自定义无效，所以用上一行来控制宽度，但这里不false掉的话上一行的也无效
    ],
];
?>
<div class="music-index">

    <h2 id="track_title">点击标题播放音乐</h2>

    <audio id="player" src="" controls></audio>

    <hr>

    <p>
        <?= Html::a('添加音乐', ['create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= RenderHelper::gridView($dataProvider, $searchModel, $gridColumns) ?>

</div>
<script>
    $(".play-list-item").click(function () {
        $("#track_title").html($(this).html());
        var player = $("#player")[0];
        var musicSrc = "<?= FileHelper::getMusicPathUrl() ?>" + $(this).data("music") + "<?= FileHelper::getMusicExtension('.') ?>";
        if (player.src == musicSrc && !player.paused) {
            player.pause();
        } else if (player.src == musicSrc && player.paused) {
            player.play();
        } else {
            player.src = musicSrc;
            player.play();
        }
    });
</script>
