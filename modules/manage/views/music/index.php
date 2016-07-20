<?php

use app\models\Music;
use app\modules\core\helpers\FileHelper;
use app\modules\core\helpers\RenderHelper;
use kartik\grid\ActionColumn;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel app\models\search\MusicSearch
 */

$this->title = '音乐';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

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
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return Music::$status_map[$model->status];
        },
        'filter' => RenderHelper::dropDownFilter('MusicSearch[status]', $searchModel->status, Music::$status_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker('MusicSearch[created_at]', false),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker('MusicSearch[updated_at]', false),
        'headerOptions' => ['width' => 160],
    ],

    [
        'class' => ActionColumn::className(),
        'template' => '{update} {delete}',
    ],
];
?>
<div class="music-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <h2 id="track_title">点击标题播放音乐</h2>

    <audio id="player" src="" controls></audio>

    <hr>

    <?= RenderHelper::gridView($dataProvider, $searchModel, $gridColumns) ?>

</div>
<script>
    $(".play-list-item").click(function () {
        $("#track_title").html($(this).html());
        var player = $("#player")[0];
        var musicSrc = "<?= FileHelper::getMusicPathUrl() ?>" + $(this).data("music") + "." + "<?= FileHelper::MUSIC_EXTENSION ?>";
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
