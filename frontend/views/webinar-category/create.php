<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebinarCategory */

$this->title = 'Create Webinar Category';
$this->params['breadcrumbs'][] = ['label' => 'Webinar Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webinar-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
