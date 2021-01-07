<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_text')->widget(CKEditor::class,[
        'editorOptions' =>
            ElFinder::ckeditorOptions('elfinder',[
                'preset' => 'standard', // basic, standard, full
                'inline' => false,
            ]),
    ]); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'published')->checkbox([
        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
        'class' => 'custom-control-input'])->label(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(\common\models\Pagecategory::getdropdownListArray(),['prompt' => 'Выбрать']) ?>

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
