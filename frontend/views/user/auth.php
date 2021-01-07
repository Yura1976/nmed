<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\widgets\alert\Alert;

//$this->title = 'Войти';
//$this->params['breadcrumbs'][] = $this->title;
$formtype = Yii::$app->request->get('formtype');
?>
    <div class="modal-header align-content-between">
        <ul class="nav nav-tabs w-100 justify-content-between mr-auto ml-auto">
            <li class="nav-item w-50" id="tab1"><a class="nav-link<?=(!isset($formtype) || $formtype == 'signin')?' active':''?>" data-toggle="tab" href="#signin">Войти</a></li>
            <li class="nav-item w-50" id="tab2"><a class="nav-link<?=($formtype == 'signup')?' active':''?>" data-toggle="tab" href="#signup">Регистрация</a></li>
        </ul>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="/images/btn_close.svg" alt="Закрыть"></span>
        </button>
    </div>
    <div class="modal-body">
    <div class="tab-content">
        <div class="alert alert-danger p-5" role="alert"></div>
        <?= Alert::widget(); ?>
        <div class="tab-pane fade show<?=(!isset($formtype) || $formtype == 'signin')?' active':''?>" id="signin">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'class' => 'auth-form',
//                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
//                    'options' => ['autocomplete' => 'off'],
                    'action' => ['user/ajax-signin']
                ]); ?>

                <?= $form->field($modelsignin, 'email')
                    ->textInput([
                        'autofocus' => true,
                        'placeholder'=>$modelsignin->getAttributeLabel('email')
                    ])->label(false) ?>

                <?= $form->field($modelsignin, 'password',
                    ['errorOptions' => [
                        'encode' => false,
                    ]])
                    ->passwordInput([
                        'placeholder'=>$modelsignin->getAttributeLabel('password'),
                        'autocomplete'=>"off",
                    ])->label(false) ?>

                <?= $form->field($modelsignin, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    <?= Html::a('Забыли пароль', ['user/request-password-reset']) ?>.
                    <br>
                    <!--                    Need new verification email? --><?//= Html::a('Resend', ['user/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Войти', [
                        'id' => 'signin-button',
                        'class' => 'btn btn-blue btn-auth w-100 p-10',
                        'name' => 'login-button'
                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>

        </div>
        <div class="tab-pane fade show<?=($formtype == 'signup')?' active':''?>" id="signup">
            <?php $form = ActiveForm::begin([
                'id' => 'signup-form',
                'class' => 'auth-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validationUrl' => \yii\helpers\Url::to(['validate-form']),
                'action' => ['user/ajax-signup']
            ]); ?>

            <?= $form->field($modelsignup, 'firstname')
                ->textInput([
                    'autofocus' => true,
                    'placeholder'=>$modelsignup->getAttributeLabel('firstname'),
                ])->label(false) ?>
            <?= $form->field($modelsignup, 'lastname')
                ->textInput([
                    'autofocus' => true,
                    'placeholder'=>$modelsignup->getAttributeLabel('lastname'),
                ])->label(false) ?>

            <?= $form->field($modelsignup, 'email')
                ->textInput([
                    'autofocus' => true,
                    'placeholder'=>$modelsignup->getAttributeLabel('email'),
                ])->label(false) ?>

            <?= $form->field($modelsignup, 'phone')->textInput([
                'placeholder'=>$modelsignup->getAttributeLabel('phone'),
                'class'=>'form-control phoneInput'
            ])->label(false)->hint('В формате +7 (___) ___-__-__') ?>

            <?= $form->field($modelsignup, 'password')
                ->passwordInput([
                    'placeholder'=>$modelsignup->getAttributeLabel('password'),
                ])->label(false) ?>

            <?= $form->field($modelsignup, 'repassword')->passwordInput([
                'placeholder'=>$modelsignup->getAttributeLabel('repassword'),
            ])->label(false) ?>

            <?= $form->field($modelsignup, 'invitation_code')
                ->textInput([
                    'maxlength' => true,
                    'placeholder'=>$modelsignup->getAttributeLabel('invitation_code'),
                ])->label(false) ?>


            <?=$form->field($modelsignup, 'issubscribe')->checkbox(['checked'=>false])?>

            <?=$form->field($modelsignup, 'agree')->checkbox(['checked'=>false])->label(\common\models\Config::getConfig(7))?>

            <div class="form-group">
                <?= $form->field($modelsignup, 'check')->hiddenInput([
                    'type' => 'hidden',
                    'id' => 'check',
                    'value' => '',
                ])->label(false) ?>
                <?= Html::submitButton('Зарегистрироваться', [
                    'class' => 'btn btn-blue btn-auth w-100 pt-3 pb-3 mt-2',
                    'id' => 'signup-button',
                    'name' => 'signup-button',
                    'onclick'=>"document.getElementById('check').value = 'nospam';"
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJsFile('@web/js/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$js = <<< JS
$(function (){
    // $('.btn-auth').on('click',function (e){
    //     $.post(
    //         form.attr('action'),
    //         form.serialize(),
    //         function(data) {
    //           console.log('data='+data);
    //           $('.modal-dialog .modal-content').html(data);
    //           $('.modal-dialog .alert').css('display','block');
    //           // $('#signup-form').css('display','none');
    //             //window.location.reload();
    //             // $('.modal').modal('hide');
    //         }
    //     );
    //    
    //     // e.preventDefault();
    //     return false;
    // });

    
    $('.phoneInput').mask('+0 (000) 000 00 00', {placeholder: "+_ (___) ___ __ __"});




//phone mask
//     function clearVal(val, limit){
//         var newVal = val.replace(/[^\d+()]+/g, '');
//         if( newVal == '' ){
//             return false;
//         }else{
//             return newVal.substring(0, limit);
//         }
//     }
//     function getResString(newVal){
//         var res = '';
//         for(var i = 0; i < newVal.length; i++){
//             if( i == 3 ){
//                 res += ' ';
//                 res += newVal.charAt(i);
//             }else if( i == 6 || i == 8 ){
//                 res += '-';
//                 res += newVal.charAt(i);
//             }else{
//                 res += newVal.charAt(i);
//             }
//         }
//         return res;
//     }
//     $(function(){
//         $('.phoneInput').on('input', function(){
//             var val = $(this).val(),
//                 limit = 13;
//             if( val == '' ) return;
//
//             var newVal = clearVal(val, limit);
//             if(!newVal){
//                 $(this).val('');
//                 return;
//             }
//             var res = getResString(newVal);
//             $(this).val(res);
//         });
//     });
//    
});
JS;
$this->registerJs( $js, $position = yii\web\View::POS_READY, $key = null  );
?>