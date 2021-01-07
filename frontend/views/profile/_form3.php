<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $profile common\models\Profile */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data',
//            'data-pjax' => true,
            'class' => 'profileform',
            'id' => 'ProfileForm3',
        ],
        'action' => Url::to(['profile/ajax-profile-update'])
    ]); ?>

    <div class="row">
        <div class="col-12">
            <h4>Контактная информация</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <?= $form->field($profile, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-5">
            <?= $form->field($profile, 'watsapp')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <?= $form->field($profile, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['id' => 'profileformbtn3', 'class' => 'btn btn-outline-blue profileformbtn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
