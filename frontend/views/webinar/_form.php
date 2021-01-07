<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Webinar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webinar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access')->textInput() ?>

    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'startsAt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utcStartsAt')->textInput() ?>

    <?= $form->field($model, 'createUserId')->textInput() ?>

    <?= $form->field($model, 'timezoneId')->textInput() ?>

    <?= $form->field($model, 'endsAt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organizationId')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'webinar' => 'Webinar', 'meeting' => 'Meeting', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->textInput() ?>

    <?= $form->field($model, 'bgimage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'eventsessionId')->textInput() ?>

    <?= $form->field($model, 'urlAlias')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
