<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use common\models\Menu;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'parent_id')->dropDownList(Menu::getMenuArray()) ?>

    <?= $form->field($model, 'place')->dropDownList(Menu::getMenuPlacesList()) ?>

    <?= $form->field($model, 'menu_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'params')->textInput() ?>


    <?= $form->field($model, 'status')->checkbox([
        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
        'class' => 'custom-control-input'])->label(); ?>


    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'pos')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
