<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WebinarCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории (разделы) вебинаров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webinar-category-index">
    <p>
        <?= Html::a('Новый раздел', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '80']
            ],
            'name',
//            'bgcolor',
//            'icon_img',
//            'created_at',
            //'updated_at',
            //'status',

            ['class' => 'common\widgets\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
