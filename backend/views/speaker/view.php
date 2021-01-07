<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Speaker */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Лекторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'firstname',
            'lastname',
            'middlename',
            'description',
            [
                'attribute' => 'avatar',
                'format' => 'raw',
                'value' => function($data){
                    return Html::img($data->getAvatar());
                }
            ],
            'work_place',
            'position',
            [
                 'attribute'=>'education_id',
                 'value' => function($data){
                    return $data->education->name;
               }
            ],
            [
                'attribute'=>'academicdegree_id',
                'value' => function($data){
                    return $data->academicdegree->name;
                }
            ],
            'phone',
            'email:email',
            'created_at:datetime',
            'updated_at:datetime',
            'slug',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ],
    ]) ?>

</div>
