<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use \common\models\FaqCategory;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Faq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faq-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer')->widget(CKEditor::class,[
        'editorOptions' =>
            ElFinder::ckeditorOptions('elfinder',[
                'preset' => 'basic', // basic, standard, full
                'inline' => false,
            ]),
    ]); ?>

    <?= $form->field($model, 'category_id')->dropDownList(FaqCategory::getCategoryArray(),['prompt' => 'Выберите раздел']) ?>

    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'pos')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'status')->checkbox([
        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
        'class' => 'custom-control-input'])->label(); ?>

    <?= $form->field($model, 'slug')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
