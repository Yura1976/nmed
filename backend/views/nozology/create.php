<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nozology */

$this->title = 'Добавить нозологию';
$this->params['breadcrumbs'][] = ['label' => 'Нозология', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nozology-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
