<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Specialty */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Специальности', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="specialty-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
