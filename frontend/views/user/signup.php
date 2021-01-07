<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<?php //var_dump(Yii::$app->controller->id); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'signup-form',
                'enableAjaxValidation' => true,
                'validationUrl' => \yii\helpers\Url::to(['validate-form']),
                'enableClientValidation' => true,
            ]); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'phone')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'repassword')->passwordInput() ?>

<!--            --><?//= $form->field($model, 'issubscribe')->checkbox([
//                'template' => "<div class=\"custom-control custom-switch\">{input} {label}</div>\n<div>{error}</div>",
//                'class' => 'custom-control-input'])->label(); ?>
            <?=$form->field($model, 'issubscribe')->checkbox(['checked'=>false])?>

            <div class="row">
                <div class="col-4">
                    <?= $form->field($model, 'invitation_code')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <?=$form->field($model, 'issubscribe')->checkbox(['checked'=>false])?>

            <?=$form->field($model, 'agree')->checkbox(['checked'=>false])?>

                <div class="form-group">
                    <?= $form->field($model, 'check')->hiddenInput([
                        'type' => 'hidden',
                        'id' => 'check',
                        'value' => '',
                    ])->label(false) ?>
                    <?= Html::submitButton('Зарегистрироваться', [
                        'class' => 'btn btn-primary',
                        'name' => 'signup-button',
                        'onclick'=>"document.getElementById('check').value = 'nospam';"
                    ]) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
