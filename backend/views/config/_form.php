<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'config_type')
        ->dropDownList([
            'int' => 'Int',
            'text' => 'Text',
            'varchar' => 'Varchar',
            'html' => 'html'
        ], ['prompt' => '']) ?>

    <?php
    if(!$model->config_type || $model->config_type == 'text') {
        echo $form->field($model, 'config_value')->textarea(['rows' => 6]);
    } elseif($model->config_type == 'html') {
//        echo $model->config_value;
        echo $form->field($model, 'config_value')->widget(CKEditor::class,[
                'editorOptions' =>
                    ElFinder::ckeditorOptions('elfinder',[
                        'preset' => 'standard', // basic, standard, full
                        'inline' => false,
                    ]),
            ]);
    } elseif($model->config_type == 'varchar' || $model->config_type == 'int'){
        echo $form->field($model, 'config_value')->textInput();
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
