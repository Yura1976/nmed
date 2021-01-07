<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <p>
        <?= Html::a('Новый шаблон', ['create'], ['class' => 'btn btn-success']) ?>
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
            'name:ntext',
//            'access',
//            'password',
//            'rule',
            //'description:ntext',
            //'additionalFields',
            //'isEventRegAllowed',
            //'startsAt',
            //'endsAt',
            //'image',
            //'imagefile',
            //'type',
            //'lang',
            //'urlAlias',
            //'lectorIds',
            //'tags',
            //'duration',
            //'ownerId',
            //'defaultRemindersEnabled',
            //'eventId',
            //'link',


            [
                'class' => 'common\widgets\grid\ActionColumn',
                'template' => '{webinars} {view} {update} {delete} ',
                'buttons' => [
                    'webinars' => function ($url, $model, $key) {
                        $url = \yii\helpers\Url::to(['webinar/index','eventIdnkomed'=>$model->id]);
                        $icon = Html::tag('span', '', ['class' => "fab fa-elementor"]);
                        return Html::a($icon, $url);
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
