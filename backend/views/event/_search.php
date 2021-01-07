<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\EventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'access') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'rule') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'additionalFields') ?>

    <?php // echo $form->field($model, 'isEventRegAllowed') ?>

    <?php // echo $form->field($model, 'startsAt') ?>

    <?php // echo $form->field($model, 'endsAt') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'imagefile') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'urlAlias') ?>

    <?php // echo $form->field($model, 'lectorIds') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'ownerId') ?>

    <?php // echo $form->field($model, 'defaultRemindersEnabled') ?>

    <?php // echo $form->field($model, 'eventId') ?>

    <?php // echo $form->field($model, 'link') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
