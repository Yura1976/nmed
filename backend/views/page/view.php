<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

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
            'full_text:html',
            'created_at:datetime',
            'updated_at:datetime',
            'slug',
            'meta_title',
            'meta_keywords',
            'meta_description',
            [
                'attribute' => 'published',
                'value' => function($data){
                    return common\models\Common::getIsPublished($data->published);
                }
            ],
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    $category = ($data->category->name) ? $data->category->name : 'Без раздела';
                    return $category;
                }
            ],
            'pos',
        ],
    ]) ?>

</div>
