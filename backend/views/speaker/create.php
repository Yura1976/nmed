<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Speaker */

$this->title = 'Новый лектор';
$this->params['breadcrumbs'][] = ['label' => 'Лекторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speaker-create">

    <?= $this->render('_form', [
        'model' => $model,
        'arr' => $arr
    ]) ?>

</div>
