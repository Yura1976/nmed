<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Speaker */

$this->title = 'Редактивароть: ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Лекторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fio, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="speaker-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
