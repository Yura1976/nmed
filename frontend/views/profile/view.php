<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = (isset($model->fio) && $model->fio !== '') ? $model->fio : 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить профиль', ['update'], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'birthday',
            'country_id',
            'city_id',
            'smallImage:image',
            'work_place:html',
            'position',
            'education_id',
            'academicdegree_id',
            'phone',
            'email:email',
            'bonus',
            'invitation_code',
            'my_invitation_code',
        ],
    ]) ?>

</div>
