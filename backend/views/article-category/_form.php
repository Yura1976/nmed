<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="article-category-form">

    <?php $form = ActiveForm::begin([
//        'enableClientValidation' => true,
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'annot_text')->widget(CKEditor::className(),[
        'editorOptions' =>
            ElFinder::ckeditorOptions('elfinder',[
                'preset' => 'basic', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
            ]),
    ]); ?>


    <?= $form->field($model, 'detail_text')->widget(CKEditor::className(),[
        'editorOptions' =>
            ElFinder::ckeditorOptions('elfinder',[
                'preset' => 'standard', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
            ]),
    ]); ?>

<!--    --><?//= $form->field($model, 'annonce_img')->fileInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'detail_img')->fileInput() ?>

    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'status')->checkbox([
                'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
                'class' => 'custom-control-input'])->label(); ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'isinindex')->checkbox([
                'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
                'class' => 'custom-control-input'])->label(); ?>
        </div>
    </div>

    <?= $form->field($model, 'pos')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
