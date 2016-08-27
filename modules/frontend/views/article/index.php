<?php

use app\models\Article;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Collapse;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\ArticleSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = '文章';
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <div class="row">
        <div class="col-md-3 pull-right-md">
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
            <?= Collapse::widget([
                'items' => [
                    [
                        'label' => '搜索文章',
                        'content' => $this->render('_search', [
                            'model' => $searchModel,
                            'sort' => $dataProvider->sort,
                        ]),
                    ]
                ],
            ]) ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading nav-tabs">
                    <span class="glyphicon glyphicon-list-alt"></span> 最新文章
                </div>
                <div class="list-group">
                    <?php
                    if ($dataProvider->totalCount) {
                        foreach ($dataProvider->models as $article) {
                            ?>
                            <a class="list-group-item" href="<?= Url::to(['view-article', 'id' => $article['id']]) ?>">
                                <span class="badge"><?= date('m-d H:i', $article['published_at']) ?></span>
                                <span class="badge"><?= $article['user']['username'] ?></span>
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
                <div style="text-align: center;">
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
