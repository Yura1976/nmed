<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Webinar */

$this->title = 'Редактировать вебинар: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Вебинары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="webinar-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
