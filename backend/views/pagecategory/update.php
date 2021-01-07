<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pagecategory */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Разделы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pagecategory-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
