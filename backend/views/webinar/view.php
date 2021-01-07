<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Common;

/* @var $this yii\web\View */
/* @var $model common\models\Webinar */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Вебинары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="webinar-view">

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
            'status',
            [
                'attribute'=>'access',
                'value'=>function($data){
                    return $data->accessName;
                }
            ],
            [
                'attribute'=>'type',
                'value'=>function($data){
                    return $data->typeName;
                }
            ],
            [
                'attribute'=>'lang',
                'value'=>function($data){
                    return $data->langName;
                }
            ],
            'startsAt:datetime',
            'endsAt:datetime',
//            'utcStartsAt',
//            'createUserId',
//            'timezoneId:datetime',
//            'organizationId',
            'description:ntext',
            [
                 'attribute' => 'speakers',
                'value' => function($data){
                    return $data->speakerList;
                }
            ],
            'image',
            [
                'attribute'=>'bgimage',
                'format' => 'image',
                'value' => function($data){
                    return Common::getFile('webinar/',$data->bgimage,$data->bgimage);
                }
            ],
            'eventsessionId',
            'urlAlias',
            'duration',
            'slug'
        ],
    ]) ?>

</div>
