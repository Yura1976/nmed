<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebinarCategory */

$this->title = 'Новый раздел';
$this->params['breadcrumbs'][] = ['label' => 'Разделы (категории)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webinar-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
