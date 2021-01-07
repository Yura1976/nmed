<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArticleCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Разделы статей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">

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
//            'annot_text:ntext',
//            'detail_text:ntext',
//            'annonce_img:ntext',
            //'detail_img:ntext',
//            'created_at:datetime',
//            [
//                'attribute' => 'status',
//                'value' => function($data){
//                    return common\models\Common::getIsPublished($data->status);
//                },
//                'filter' => common\models\Common::getPublishedArray(),
//            ],
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'isinindex',
            //'slug',
            //'meta_title',
            //'meta_keywords',
            //'meta_description',

            ['class' => 'common\widgets\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
