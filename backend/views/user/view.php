<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Зарегистрированные пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

<!--    <p>-->
<!--        --><?//= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<!--        --><?//= Html::a('Удалить', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
<!--    </p>-->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email:email',
            'profile.lastname',
            'profile.firstname',
            'profile.middlename',
            'profile.birthday',
            'profile.work_place',
            [
                'attribute' => 'profile.position_id',
                'value' => function($data){
                    return ($data->profile) ? $data->profile->position->name : 'Не указано';
                },
            ],
            [
                'attribute' => 'profile.education_id',
                'value' => function($data){
                    return ($data->profile->education) ? $data->profile->education->name : 'Не указано';
                },
            ],
            [
                'attribute' => 'profile.academicdegree_id',
                'value' => function($data){
                    return ($data->profile->academicdegree) ? $data->profile->academicdegree->name : 'Не указано';
                },
            ],
            [
                'attribute' => 'profile.country.name',
                'label' => 'Страна',
            ],
            [
               'attribute' => 'profile.avatar',
               'format' => ['image',['width'=>'50','height'=>'50']],
                'value' => function($data){
                    $img = $data->profile->getAvatarimg($data->id);
                   return $img['img'];
                }
            ],
            [
               'attribute' => 'profile.phone'
            ],
            'profile.watsapp',
            [
               'attribute' => 'profile.bonus'
            ],
            'profile.invitation_code',
            'profile.my_invitation_code',
            [
                'attribute' => 'status',
                'value' => function($data){
                    return $data->getStatusName($data->status);
                }
            ],

            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
