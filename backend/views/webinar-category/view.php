<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WebinarCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Разделы вебинаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="webinar-category-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
//            [
//                'attribute' => 'bgcolor',
//                'format' => 'raw',
//                'value' => function($data){
//                    if($data->bgcolor){
//                        return '<div style="background-color: #'.$data->bgcolor.'; padding: 7px 12px;">#'.$data->bgcolor.'</div>';
//                    } else{
//                        return "";
//                    }
//                }
//            ],
//            [
//                'attribute' => 'icon_img',
//                'format' => 'raw',
//                'value' => function($data){
//                    return ($icon = \common\models\Common::getFile('webinar/category/', $data->icon_img, $data->icon_img)) ? Html::img($icon) : '';
//                }
//            ],
//            [
//                'attribute' => 'bg_img',
//                'format' => 'raw',
//                'value' => function($data){
//                    return ($icon = \common\models\Common::getFile('webinar/category/', $data->bg_img, $data->bg_img)) ? Html::img($icon) : '';
//                }
//            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'status',
                'value' => function($data){
                    return common\models\Common::getIsPublished($data->status);
                }
            ],
            'cssclass',
        ],
    ]) ?>

</div>
