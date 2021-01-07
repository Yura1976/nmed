<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <p>
        <?= Html::a('Новый пунт меню', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'parent_id',
                'value' => function($data){
                    return $data->parentName;
                }
            ],
            [
                'attribute' => 'place',
                'value' => function($data){
                    return $data->placeName;
                }
            ],
//            'pageurl',
            //'params',
            //'status',

            ['class' => 'common\widgets\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
