<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
//use kartik\typeahead\Typeahead;
use kartik\file\FileInput;
use kartik\select2\Select2;
//use kartik\depdrop\DepDrop;


/* @var $this yii\web\View */
/* @var $profile common\models\Profile */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="profile-form">
    <?php $form = ActiveForm::begin([
            'options' => [
                'enctype'=>'multipart/form-data',
//                'data-pjax' => true,
                'class' => 'profileform',
                'id' => 'ProfileForm1',
            ],
        'action' => Url::to(['profile/ajax-profile-update'])
    ]); ?>
    <div class="row">
        <div class="col-12">
            <h4>Личная информация</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">

            <?= $form->field($profile, 'lastname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($profile, 'firstname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($profile, 'middlename')->textInput(['maxlength' => true]) ?>

            <?= $form->field($profile, 'birthday')
                ->widget(yii\jui\DatePicker::classname(), [
                    'dateFormat' => 'php:d.m.Y',
                    'options' => [
        //                    'readonly' => true
                    ],
                    'clientOptions' => [
                        'changeMonth' => true,
                        'changeYear' => true,
        //                'showOn'=> "button",
                        'yearRange' => '1940:'.date('Y'),
                        'maxDate' => '+0d'
                    ]]) ?>

            <?php
//            echo $form->field($profile, 'country_id')->widget(DepDrop::classname(), [
//                'data' => [6 => 'Bank'],
//                'options' => ['placeholder' => 'Select ...'],
//                'type' => DepDrop::TYPE_SELECT2,
//                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
//                'pluginOptions' => [
//                    'depends' => ['account-lev0'],
//                    'url' => Url::to(['/account/child-account']),
//                    'loadingText' => 'Loading child level 1 ...',
//                ]
//            ]);
//            echo $form->field($profile, 'country_id')->widget(DepDrop::class, [
//                'language' => 'ru',
//                'type' => DepDrop::TYPE_SELECT2,
//                'initValueText' => $profile->country_name,
//                'options' => [
//                    'placeholder' => 'Страна ...',
//                    'multyple' => false,
//                ],
////                'pluginEvents' => [
////                    "select2:open" => 'function() { $(".select2-results__options").css("background-color","red") }',
////                ],
//                'select2Options' => [
//                    'depends' => ['account-lev0'],
//                    'minimumInputLength' => 1,
//                    'allowClear' => true,
//                    'highlight' => true,
//                    'ajax' => [
//                        'url' => \yii\helpers\Url::toRoute(['/profile/regionlist']),
//                        'dataType' => 'json',
//                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
////                        'data' => new \yii\web\JsExpression('function(term,page) { return {q:term}; }'),
////                        'results' => new \yii\web\JsExpression('function(data,page) { return {results:data.results}; }'),
//                    ],
//                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
//                    'templateResult' => new JsExpression('function(country) { return country.text; }'),
//                    'templateSelection' => new JsExpression('function (country) { return country.text; }'),
//                    /**
//                     * Вот это необходимо что при обновлении формы норм инициализировался выбранный элемент  - то что в доках - initScript
//                     * По сути мы должны вернуть json - объект со стартовыми id и текст
//                     **/
////                    'initSelection' => new \yii\web\JsExpression('function(element,callback){
////                            return callback('.
////                        ($profile->isNewRecord
////                            ? '{"id":null,"text":""}'
////                            :Json::encode(["id"=>$profile->country_id,"text"=>$profile->country_name])
////                        ).')
////                              }')
//                ],
//            ]);

            echo $form->field($profile, 'country_id')->widget(Select2::class, [
                'language' => 'ru',
                'initValueText' => $profile->country_name,
                'options' => [
                    'placeholder' => 'Страна ...',
                    'multyple' => false,
                ],
//                'pluginEvents' => [
//                    "select2:open" => 'function() { $(".select2-results__options").css("background-color","red") }',
//                ],
                'pluginOptions' => [
                    'minimumInputLength' => 1,
                    'allowClear' => true,
                    'highlight' => true,
                    'ajax' => [
                        'url' => \yii\helpers\Url::toRoute(['/profile/regionlist']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term,regiontype:1}; }'),
//                        'data' => new \yii\web\JsExpression('function(term,page) { return {q:term}; }'),
//                        'results' => new \yii\web\JsExpression('function(data,page) { return {results:data.results}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(country) { return country.text; }'),
                    'templateSelection' => new JsExpression('function (country) { return country.text; }'),
                    /**
                     * Вот это необходимо что при обновлении формы норм инициализировался выбранный элемент  - то что в доках - initScript
                     * По сути мы должны вернуть json - объект со стартовыми id и текст
                     **/
//                    'initSelection' => new \yii\web\JsExpression('function(element,callback){
//                            return callback('.
//                        ($profile->isNewRecord
//                            ? '{"id":null,"text":""}'
//                            :Json::encode(["id"=>$profile->country_id,"text"=>$profile->country_name])
//                        ).')
//                              }')
                ],
            ]);

//            echo $form->field($profile, 'city_id')->widget(DepDrop::classname(), [
////                'data' => [6 => 'Bank',7=>'Иркутск'],
//                'options' => ['placeholder' => 'Select ...'],
//                'type' => DepDrop::TYPE_SELECT2,
//                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
//                'pluginOptions' => [
//                    'depends' => ['profile-country_id'],
//                    'url' => Url::to(['/profile/regionlist']),
//                    'loadingText' => 'Loading child level 1 ...',
//                ]
//            ]);


 ?>

            <?php
            echo $form->field($profile, 'city_id')->widget(Select2::class, [
                'language' => 'ru',
                'initValueText' => $profile->city_name,
                'options' => [
                    'placeholder' => 'Город ...',
                    'multyple' => false,
                ],
//                'pluginEvents' => [
//                    "select2:open" => 'function() { $(".select2-results__options").css("background-color","red") }',
//                ],
                'pluginOptions' => [
                    'minimumInputLength' => 1,
                    'allowClear' => true,
                    'ajax' => [
                        'url' => \yii\helpers\Url::toRoute(['/profile/regionlist']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term,regiontype:3,parentid:$("#profileform1-country_id").val()}; }'),
//                        'data' => new \yii\web\JsExpression('function(term,page) { return {q:term}; }'),
//                        'results' => new \yii\web\JsExpression('function(data,page) { return {results:data.results}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(country) { return country.text; }'),
                    'templateSelection' => new JsExpression('function (country) { return country.text; }'),
                    /**
                     * Вот это необходимо что при обновлении формы норм инициализировался выбранный элемент  - то что в доках - initScript
                     * По сути мы должны вернуть json - объект со стартовыми id и текст
                     **/
//                    'initSelection' => new \yii\web\JsExpression('function(element,callback){
//                            return callback('.
//                        ($profile->isNewRecord
//                            ? '{"id":null,"text":""}'
//                            :Json::encode(["id"=>$profile->country_id,"text"=>$profile->country_name])
//                        ).')
//                              }')
                ],
            ]);
            ?>
<!--            --><?//=$form->field($profile, 'country_id')->textInput()->label(false)?>
<!--            --><?//= $form->field($profile, 'city_name')->widget(Typeahead::classname(), [
//                'dataset' => [
//                    [
//                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                        'display' => 'value',
//                        //'prefetch' => $baseUrl . '/samples/countries.json',
//                        'remote' => [
//                            'url' => Url::to(['/profile/regionlist']) . '?regiontype=3&q=%QUERY',
//                            'wildcard' => '%QUERY',
//                        ],
//                    ]
//                ],
//                'pluginOptions' => ['highlight' => true],
//                'options' => ['placeholder' => 'Выбрать город ...'],
//            ]);
            ?>


            <?= $form->field($profile, 'position_id')->dropDownList(
                            $arr['position'],
                            ['prompt' => 'Выберите должность...']
                    ); ?>

            <?= $form->field($profile, 'work_place')->textInput() ?>

        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body avatar" align="center">
                    <div id="uploaded_image">
                        <?php if($profile->file): ?>
                            <div class="uploaded-ava"><img src="<?=$profile->file?>" class="img-thumbnail" alt=""></div>
                        <?php else: ?>
                            <div class="noavatar"><img src="/images/profile/noavatar.svg" class="img-thumbnail" alt=""></div>
                        <?php endif; ?>
                        <label for="upload_image" class="label">
                            <?php //echo $form->field($profile,'file')->fileInput(['class' => 'form-control custom-file-input','name'=>'upload_image','id'=>'upload_image'])->label(false)?>
                            <input type="file" name="upload_image" class="imageuploadlink" id="upload_image">
<!--                        <span class="custom-file-control cursor-pointer">Выбрать файл</span>-->
                            <span class="custom-file-control cursor-pointer title">Загрузить фото</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= $form->field($profile, 'agree')->checkbox(['checked'=>false])
                ->label('Я принимаю условия оферты (или пользовательское соглашение) и политику обработки персональных данных') ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['id' => 'profileformbtn1', 'class' => 'btn btn-outline-blue profileformbtn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

