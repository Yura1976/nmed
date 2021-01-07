<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Academicdegree */

$this->title = 'Добавить ученую степень';
$this->params['breadcrumbs'][] = ['label' => 'Ученые степени', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academicdegree-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
