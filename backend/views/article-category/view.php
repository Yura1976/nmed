<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Разделы статей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-category-view">

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
            'annot_text:html',
            'detail_text:html',
//            'annonce_img:ntext',
//            'detail_img:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'created_by',
                'format' => 'raw',
                'value' => function($data){
                    $username = ($data->createdBy->email) ?
                        Html::a($data->createdBy->email,['/user/view','id'=>$data->created_by]) : 'Не указано';
                    return $username;
                }
            ],
            [
                'attribute' => 'updated_by',
                'format' => 'raw',
                'value' => function($data){
                    $username = ($data->updatedBy->email) ?
                        Html::a($data->updatedBy->email,['/user/view','id'=>$data->updated_by]) : 'Не указано';
                    return $username;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($data){
                    return common\models\Common::getIsPublished($data->status);
                }
            ],
            'pos',
            [
                'attribute' => 'isinindex',
                'value' => function($data){
                    return ($data->isinindex == 1) ? 'Да' : 'Нет';
                }
            ],
            'slug',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ],
    ]) ?>

</div>
