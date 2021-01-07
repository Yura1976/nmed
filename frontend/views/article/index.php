<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">
<!--    <div class="article-index">-->

    <?php if($category !== null):?>
    <h2><?= Html::encode($category->name) ?></h2>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="row align-items-stretch b-height">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'class' => 'row align-items-stretch b-height',
                'id' => 'news-list',
            ],
            'itemOptions' => [
                'tag' => 'div',
                'class' => 'article-item col-4 g',
            ],
            'itemView' => '_list',
            'viewParams' => ['category' => $category],
            'layout' => "{items}\n{pager}",
            'emptyText' => 'Нет статей'
        ]) ?>
        </div>
    <?php Pjax::end(); ?>

</div>
