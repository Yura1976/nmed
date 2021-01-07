<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

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
            [
                'attribute' => 'categoryids',
                'value' => function($data){

                    $cats = $data->getStrCategories($data);
                    return ($cats) ? $cats : 'Не выбраны';

                }
            ],
            [
                'attribute' => 'bg_img',
                'format' => 'raw',
                'value' => function($model){
                    if (!empty($model->bg_img)) {
                        $bg_img = Yii::getAlias('@frontend') . '/web/uploads/articles/' . $model->bg_img;
                        if (is_file($bg_img)) {
                            $url = substr('/adminpabel','', Yii::getAlias('@web')) . '/uploads/articles/' . $model->bg_img;
                            return Html::a('Фоновое изображение', $url, ['data-pjax' => 0, 'target' => '_blank']);
                        } else {
                            return "Изображение не загружено";
                        }
                    } else {
                        return "Изображение не загружено";
                    }
                }
            ],
            [
                'attribute' => 'annonce_img',
                'format' => 'raw',
                'value' => function($model){
                    if (!empty($model->bg_img)) {
                        $annonce_img = Yii::getAlias('@frontend') . '/web/uploads/articles/' . $model->annonce_img;
                        if (is_file($annonce_img)) {
                            $url = substr('/adminpabel','', Yii::getAlias('@web')) . '/uploads/articles/' . $model->annonce_img;
                            return Html::a('Аннонсовое изображение', $url, ['data-pjax' => 0, 'target' => '_blank']);
                        } else {
                            return "Изображение не загружено";
                        }
                    } else {
                        return "Изображение не загружено";
                    }
                }
            ],

            'created_at:datetime',
            'updated_at:datetime',

            [
                'attribute' => 'created_by',
                'format' => 'raw',
                'value' => function($data){
                    $email = ($data->createdBy->email) ?
                        Html::a($data->createdBy->email,['/user/view','id'=>$data->created_by]) : 'Не указано';
                    return $email;
                }
            ],
            'data_show',
            [
                'attribute' => 'status',
                'value' => function($data){
                    return common\models\Common::getIsPublished($data->status);
                }
            ],
            [
                'attribute' => 'isinindex',
                'value' => function($data){
                    return ($data->isinindex == 1) ? 'Да' : 'Нет';
                }
            ],
            'views',
            'rate',
            'comments',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'slug',
        ],
    ]) ?>

</div>
