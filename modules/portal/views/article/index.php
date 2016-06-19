<?php

use app\models\Article;
use app\modules\core\helpers\RenderHelper;
use kartik\grid\ActionColumn;
use kartik\grid\SerialColumn;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\ArticleSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $articles
 * @var $pages yii\data\Pagination;
 */

$this->title = '文章';
//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
?>
<div class="article-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ButtonDropdown::widget([
        'label' => '发布文章',
        'containerOptions' => [
            'style' => [
                'margin-bottom' => '15px',
            ],
        ],
        'options' => ['class' => 'btn-info'],
        'dropdown' => [
            'items' => [
                ['label' => 'Markdown', 'url' => ['create']],
                ['label' => 'Html', 'url' => ['create', 'type' => Article::TYPE_HTML]],
            ],
        ],
    ]) ?>

    <div class="row panel">
        <!--<div class="panel-heading nav-tabs">
            <span class="glyphicon glyphicon-list-alt"></span> 最新文章
        </div>-->
        <div class="list-group">
            <?php
            if (count($articles)) {
                foreach ($articles as $article) {
                    ?>
                    <a class="list-group-item" href="<?= Url::to(['view-article', 'id' => $article['id']]) ?>">
                        <span class="badge"><?= $article['published_at'] ?></span>
                        <span class="badge"><?= $article['username'] ?></span>
                        <?= $article['title'] ?>
                    </a>
                    <?php
                }
            } else {
                ?>
                <div class="list-group-item">没有数据</div>
                <?php
            }
            ?>
        </div>
        <?= LinkPager::widget(['pagination' => $pages]) ?>
    </div>

</div>
