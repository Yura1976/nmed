<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SubscribingType */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Типы подписок', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="subscribing-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
