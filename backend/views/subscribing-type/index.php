<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SubscribingTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы подписок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscribing-type-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
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
//            'iconStyle',
//            'status',
//            'created_at',
            //'updated_at',
            //'pos',

            ['class' => 'common\widgets\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
