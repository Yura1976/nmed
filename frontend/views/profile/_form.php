<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $profile common\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12">
            <h4>Личная информация</h4>
        </div>
    </div>
    <?= $form->field($profile, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($profile, 'birthday')->widget(yii\jui\DatePicker::classname(), ['dateFormat' => 'php:M d, Y', 'options' => ['readonly' => true], 'clientOptions' => [ 'changeMonth' => true, 'changeYear' => true, 'yearRange' => '1980:'.date('Y'), 'maxDate' => '+0d']]) ?>

    <div class="row">
        <div class="col-12">
            <h4>Квалификация</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <?= $form->field($profile, 'country_id')->textInput() ?>
        </div>
        <div class="col-2">
            <?= $form->field($profile, 'city_id')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <?= $form->field($profile, 'work_place')->textInput() ?>
        </div>
        <div class="col-6">
            <br><br><?= $form->field($profile, 'isnotworking')->checkbox(['checked'=>false]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <?= $form->field($profile, 'position')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4>Квалификация</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($profile, 'education_id')->dropDownList($arr['education'],['prompt' => 'Выберите образование...']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($profile, 'academicdegree_id')->dropDownList($arr['academicdegree'],['prompt' => 'Выберите ученую степень...']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4>Специальность</h4>
        </div>
        <div class="col-6">
            <?= $form->field($profile, 'specialtyids')->widget(Select2::classname(), [
                'data' => \common\models\Specialty::getSpecialtyArray(),
                'language' => Yii::$app->language,

                'bsVersion' => '4.x',
                'options' => [
                    'multiple' => true,
                    'placeholder' => 'Выберите специальность'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <h4>Контактная информация</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($profile, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($profile, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4>Настройки рассылки</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-6"><?=$profile->subscribingids?>
            <?= $form->field($profile, 'subscribingids')->widget(Select2::classname(), [
                'data' => \common\models\SubscribingType::getSubscribingArray(),
                'bsVersion' => '4.x',
                'options' => [
                    'multiple' => true,
                    'placeholder' => 'Выберите способы получения рассылки'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
