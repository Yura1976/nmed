<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\EducationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Образование';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-index">

    <p>
        <?= Html::a('Добавить образование', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\bootstrap4\LinkPager::class
        ],
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
                'attribute' => 'status',
                'value' => function($data){
                    return common\models\Common::getIsPublished($data->status);
                },
                'filter' => common\models\Common::getPublishedArray(),
            ],
            pos,

//            'created_at',
//            'updated_at',

            ['class' => 'common\widgets\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
