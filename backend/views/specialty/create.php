<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Specialty */

$this->title = 'Добавить специальность';
$this->params['breadcrumbs'][] = ['label' => 'Специальности', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specialty-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
