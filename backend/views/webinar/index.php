<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WebinarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мероприятия';
$this->params['breadcrumbs'][] = $this->title;
$createurl = ($eventId = Yii::$app->request->get('eventIdnkomed')) ? ['create','eventIdnkomed'=>$eventId] : ['create'];
?>
<div class="webinar-index">

    <p>
        <?= Html::a('Новое мероприятие', $createurl, ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if($event->name): ?>
    <h3><?=$event->name?></h3>
    <?php endif; ?>
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
//            'status',
//            'access',
//            'lang',
            'startsAt:datetime',
            //'utcStartsAt',
            //'createUserId',
            //'timezoneId:datetime',
            //'endsAt',
            //'organizationId',
            //'type',
            //'description:ntext',
            //'image',
            //'bgimage',
            //'eventsessionId',
            //'urlAlias',
            //'duration',


            ['class' => 'common\widgets\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
