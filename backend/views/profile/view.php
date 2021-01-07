<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->user_id], [
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
            'user_id',
            'fio',
            'birthday',
            'country_id',
            'city_id',
            'work_place:ntext',
            'isnotworking',
            'position',
            'education_id',
            'academicdegree_id',
            'phone',
            'email:email',
            'created_at',
            'updated_at',
            'last_login_at',
            'last_login_ip',
            'bonus',
            'slug',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'invitation_code',
            'my_invitation_code',
        ],
    ]) ?>

</div>
