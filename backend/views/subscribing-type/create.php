<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SubscribingType */

$this->title = 'Добавить тип подписки';
$this->params['breadcrumbs'][] = ['label' => 'Типы подписок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscribing-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
