<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nozology */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Нозология', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="nozology-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
