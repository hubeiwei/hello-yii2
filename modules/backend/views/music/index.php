<?php

use app\models\Music;
use hubeiwei\yii2tools\grid\ActionColumn;
use hubeiwei\yii2tools\grid\SerialColumn;
use hubeiwei\yii2tools\helpers\Render;
use hubeiwei\yii2tools\widgets\DateRangePicker;
use hubeiwei\yii2tools\widgets\JsBlock;
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
        'attribute' => 'username',
        'value' => function ($model) {
            return Html::a($model->username, ['index', 'MusicSearch[user_id]' => $model->user_id]);
        },
        'format' => 'html',
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'visible',
        'value' => function ($model) {
            return Music::visibleMap($model->visible);
        },
        'filter' => Music::visibleMap(),
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return Music::statusMap($model->status);
        },
        'filter' => Music::statusMap(),
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
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

    <?= Render::dynaGrid([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]) ?>

</div>
<?php JsBlock::begin(); ?>
<script>
    $(".play-list-item").click(function () {
        $("#track_title").html($(this).html());
        var player = $("#player")[0];
        var musicSrc = "<?= Music::getMusicPathUrl() ?>" + $(this).data("music");
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
<?php JsBlock::end(); ?>
