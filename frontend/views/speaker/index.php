<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SpeakerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Лекторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speaker-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
                'tag' => 'div',
                'class' => 'row align-items-stretch b-height',
                'id' => 'news-list',
        ],
        'itemOptions' => [
                'tag' => 'div',
                'class' => 'article-item col-12 col-sm-6 col-md-6 col-lg-3 text-center g',
            ],
        'itemView' => '_list',
//        'viewParams' => ['category' => $category],
        'layout' => "{items}\n{pager}",
    ]) ?>

    <?php Pjax::end(); ?>

</div>
