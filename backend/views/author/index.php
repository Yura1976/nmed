<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AuthorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <p>
        <?= Html::a('Новый автор', ['create'], ['class' => 'btn btn-success']) ?>
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
            'firstname',
            'lastname',
            'middlename',
            //'company_id',
            //'position_id',
            //'education_id',
            //'academicdegree_id',
            //'phone',
            //'email:email',
            'created_at:datetime',
            //'updated_at',
            //'slug',
            //'meta_title',
            //'meta_keywords',
            //'meta_description',

            ['class' => 'common\widgets\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
