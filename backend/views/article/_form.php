<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'
            ]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

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
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'categoryids')->widget(Select2::classname(), [
                'data' => \common\models\ArticleCategory::getCategoryArray(),
                'bsVersion' => '4.x',
                'options' => [
                    'multiple' => true,
                    'placeholder' => 'Выберите разделы'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'authorids')->widget(Select2::classname(), [
                'data' => $model->getAuthorArray(),
                'bsVersion' => '4.x',
                'options' => [
                    'multiple' => true,
                    'placeholder' => 'Выберите авторов'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/author/author-list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(country) { return country.text; }'),
                    'templateSelection' => new JsExpression('function (country) { return country.text; }'),
                ],
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <fieldset>
                <legend>Загрузить фоновое изображение</legend>
                <?= $form->field($model, 'bg_img')->fileInput(); ?>
                <?php
                if (!empty($model->bg_img)) {
                    $bg_img = Yii::getAlias('@frontend') . '/web/uploads/articles/' . $model->bg_img;
                    if (is_file($bg_img)) {
                        $url = substr('/adminpabel','', Yii::getAlias('@web')) . '/uploads/articles/' . $model->bg_img;
                        echo 'Уже загружено ', Html::a('фоновое изображение', $url, ['target' => '_blank']);
                    }
                }
                ?>
            </fieldset>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <fieldset>
                <legend>Загрузить анонсовое изображение</legend>
            <?= $form->field($model, 'annonce_img')->fileInput() ?>
            <?php
            if (!empty($model->annonce_img)) {
                $annonce_img = Yii::getAlias('@frontend') . '/web/uploads/articles/' . $model->annonce_img;
                if (is_file($annonce_img)) {
                    $url = substr('/adminpabel','', Yii::getAlias('@web')) . '/uploads/articles/' . $model->annonce_img;
                    echo 'Уже загружено ', Html::a('анонсовое изображение', $url, ['target' => '_blank']);
                }
            }
            ?>
            </fieldset>
        </div>
    </div>

<!--    --><?//= $form->field($model, 'detail_img')->fileInput() ?>

    <?= $form->field($model, 'data_show')
        ->widget(yii\jui\DatePicker::classname(), [
            'dateFormat' => 'php:d.m.Y',
            'options' => [
                //                    'readonly' => true
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                //                'showOn'=> "button",
                'yearRange' => '1990:'.date('Y'),
                'maxDate' => '+0d'
            ]]) ?>

    <?= $form->field($model, 'isinindex')->checkbox([
        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
        'class' => 'custom-control-input'])->label(); ?>

    <?= $form->field($model, 'pos')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'status')->checkbox([
        'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
        'class' => 'custom-control-input'])->label(); ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
