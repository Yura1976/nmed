<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Event */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">
    <p>
        <?= Html::a('Вебинары', ['webinar/index', 'eventId' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'name:ntext',
            [
               'attribute'=>'access',
                'value'=>function($data){
                    return $data->accessName;
                }
            ],
            'rule',
            'description:ntext',
            'additionalFields',
            [
                'attribute'=>'isEventRegAllowed',
                'value'=>function($data){
                    return $data->isEventRegAllowedName;
                }
            ],
            'startsAt:datetime',
            'endsAt:datetime',
            'image',
            'imagefile',
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
            'urlAlias',
            'lectorIds',
            'tags',
            'duration',
            'ownerId',
            'defaultRemindersEnabled',
            'eventId',
            'link',
        ],
    ]) ?>

</div>
