<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Bonus */

$this->title = 'Добавить бонус';
$this->params['breadcrumbs'][] = ['label' => 'Бонусы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bonus-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
