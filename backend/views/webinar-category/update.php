<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebinarCategory */

$this->title = 'Редактировать раздел ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Разделы вебинаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="webinar-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
