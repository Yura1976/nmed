<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\WebinarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webinar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'access') ?>

    <?= $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'startsAt') ?>

    <?php // echo $form->field($model, 'utcStartsAt') ?>

    <?php // echo $form->field($model, 'createUserId') ?>

    <?php // echo $form->field($model, 'timezoneId') ?>

    <?php // echo $form->field($model, 'endsAt') ?>

    <?php // echo $form->field($model, 'organizationId') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'bgimage') ?>

    <?php // echo $form->field($model, 'eventsessionId') ?>

    <?php // echo $form->field($model, 'urlAlias') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
