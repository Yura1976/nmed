<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model common\models\WebinarCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webinar-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    <div class="row">-->
<!--        <div class="col-12 mb-3">-->
<!--            <fieldset>-->
<!--                --><?//= $form->field($model, 'bg_img')->fileInput(); ?>
<!--                --><?php
//                if (!empty($model->bg_img) && $imgurl = \common\models\Common::getFile('webinar/category/', $model->bg_img, $model->bg_img)) {
//                    echo 'Уже загружено ', Html::a('изображение', $imgurl, ['target' => '_blank']);
//                }
//                ?>
<!--            </fieldset>-->
<!--        </div>-->
<!--    </div>-->

    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'cssclass')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, 'status')->checkbox([
        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
        'class' => 'custom-control-input'])->label('Активно'); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
