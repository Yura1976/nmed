<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pagecategory */

$this->title = 'Новый раздел';
$this->params['breadcrumbs'][] = ['label' => 'Разделы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagecategory-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
