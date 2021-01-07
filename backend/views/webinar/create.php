<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Webinar */

$this->title = 'Новый вебинар';
$this->params['breadcrumbs'][] = ['label' => 'Вебинары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webinar-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
