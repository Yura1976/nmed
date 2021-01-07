<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Education */

$this->title = 'Добавить образование';
$this->params['breadcrumbs'][] = ['label' => 'Образование (список)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
