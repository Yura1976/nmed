<?php

use common\models\Speaker;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Event */

$this->title = 'Новый шаблон';
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">


    <?= $this->render('_form', [
        'model' => $model,
//        'modelsSpeaker' => $modelsSpeaker,
    ]) ?>

</div>
