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

$this->title = '我的音乐';

$gridColumns = [
    ['class' => SerialColumn::className()],

    [
        'attribute' => 'track_title',
        'value' => function ($model) {
            return Html::a($model->track_title, 'javascript:void(0)', [
                'class' => 'playlist',
                'style' => ['display' => 'block'],
                'data-music' => $model->music_file,
            ]);
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'visible',
        'value' => function ($model) {
            /** @var $model Music */
            return Music::visibleMap($model->visible);
        },
        'filter' => Music::visibleMap(),
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            /** @var $model Music */
            return Music::statusMap($model->status);
        },
        'filter' => Music::statusMap(),
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
    ],

    [
        'class' => ActionColumn::className(),
        'template' => '{update} {delete}',
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

    <?= Render::gridView([
    	'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => $gridColumns,
	]) ?>

</div>
<?php JsBlock::begin(); ?>
<script>
    $(".playlist").click(function () {
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
