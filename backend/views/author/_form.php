<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Author */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="author-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data',
        ]]); ?>

    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <fieldset>
                <legend>Загрузить фото</legend>
                <?= $form->field($model, 'avatar')->fileInput(); ?>
                <?php
                if (!empty($model->avatar)) {
                    $bg_img = Yii::getAlias('@frontend') . '/web/uploads/author/' . $model->avatar;
                    if (is_file($bg_img)) {
                        $url = substr('/adminpanel','', Yii::getAlias('@web')) . '/uploads/author/' . $model->avatar;
                        echo 'Уже загружено ', Html::a('фоновое изображение', $url, ['target' => '_blank']);
                    }
                }
                ?>
            </fieldset>
        </div>
    </div>

    <?= $form->field($model, 'work_place')->textInput() ?>

    <?= $form->field($model, 'position')->textInput(); ?>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'education_id')->dropDownList($arr['education'],['prompt' => 'Выберите образование...']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'academicdegree_id')->dropDownList($arr['academicdegree'],['prompt' => 'Выберите ученую степень...']) ?>
        </div>
    </div>
    <div class="col-10">
        <?= $form->field($model, 'specialtyids')->widget(Select2::classname(), [
            'maintainOrder' => true,
            'options' => [
                'placeholder' => 'Выбрать специализацию',
                'multiple' => true,
                'class' => 'form-control select2-search__field'
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => Url::to(['/author/specialty-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(specialty) { return specialty.text; }'),
                'templateSelection' => new JsExpression('function (specialty) { return specialty.text; }'),
            ],
        ]);


        ?>
    </div>

    <div class="row">
        <div class="col-5">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-5">
            <?= $form->field($model, 'email')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
