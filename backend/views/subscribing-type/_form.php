<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubscribingType */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="subscribing-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iconStyle')->textInput(['maxlength' => true]) ?>


    <div class="row">
        <div class="col-2">
            <?= $form->field($model, 'pos')->textInput(['type' => 'number']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <?= $form->field($model, 'sendpulse')->dropDownList($model->getSendpulseArray(),['prompt' => 'Выбрать']) ?>
        </div>
    </div>

    <?= $form->field($model, 'status')->checkbox([
        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
        'class' => 'custom-control-input'])->label(); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
