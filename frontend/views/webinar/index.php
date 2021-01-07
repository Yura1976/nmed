<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WebinarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вебинары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webinar-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <div class="d-flex mt-3 data-webinar-filter">
        <div class="mr-3">
            <a href="<?=Url::to(['index','from_date'=>date("d.m.Y H:i:s")])?>"<?=(Yii::$app->request->get('from_date') !== null ) ? " class='active'" : ""?>>Ближайшие вебинары</a>
        </div>
        <div>
            <a href="<?=Url::to(['index','to_date'=>date("d.m.Y H:i:s")])?>"<?=(Yii::$app->request->get('to_date') !== null ) ? " class='active'" : ""?>>Прошедшие вебинары</a>
        </div>
    </div>
    <?php //var_dump($dataProvider);?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
//            'class' => 'row align-items-stretch b-height',
            'class' => 'row mt-5 webinar-list',
            'id' => 'news-list',
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'webinar-item col-12 col-lg-6 g',
        ],
        'itemView' => '_list',
//        'viewParams' => ['category' => $category],
        'layout' => "{items}\n{pager}",
    ]) ?>

    <?php Pjax::end(); ?>

</div>
