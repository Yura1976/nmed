<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\datetime\DateTimePicker;
use unclead\multipleinput\MultipleInput;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Webinar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webinar-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data',
        ]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'access')->dropDownList($model->accessArray,['prompt' => 'Выбрать ...']) ?>
        </div>
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'lang')->dropDownList([ 'RU' => 'Русский', 'EN' => 'Английский' ], ['prompt' => 'Выбрать']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'startsAt')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => 'Укажите дату и время ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.m.yyyy H:m:s',
                    'todayBtn'=>true,
                ]
            ]);?>
        </div>
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'endsAt')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => 'Укажите дату и время ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.m.yyyy H:m:s',
                    'todayBtn'=>true,
                ]
            ]);?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-12 col-md-5 mb-3">
            <fieldset>
                <?= $form->field($model, 'bgimage')->fileInput(); ?>
                <?php
                if (!empty($model->bgimage) && $imgurl = \common\models\Common::getFile('webinar/', $model->bgimage, $model->bgimage)) {
                    echo 'Уже загружено ', Html::a('изображение', $imgurl, ['target' => '_blank']);
                }
                ?>
            </fieldset>
        </div>
    </div>
    <?= $form->field($model, 'webinarcategoryids')->widget(Select2::classname(), [
        'data' => $model->getCategoryArray(),
//        'value' => 1,
        'language' => Yii::$app->language,
        'options' => [
            'multiple' => true,
            'placeholder' => 'Выбрать'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'speakerss')->widget(MultipleInput::className(), [
        'min' => 1,
        'max' => 5,
        'allowEmptyList' => false,
        'rendererClass' => \unclead\multipleinput\renderers\ListRenderer::className(),
//        'theme' => 'bs',
        'addButtonOptions' => ['class'=>'fas fa-plus-circle'],
        'removeButtonOptions' => ['class'=>'fas fa-minus-circle'],
        'extraButtons' => function ($model, $index, $context) {
            return '<span class="unclead_span"><a href="#" onclick="return moveChoiceTo(this, -1);"><i class="glyphicon glyphicon-circle-arrow-up"></i></a>
                        <a href="#" onclick="return moveChoiceTo(this, 1);"><i class="glyphicon glyphicon-circle-arrow-down"></i></a></span>'
                //                    .'<label class="btn btn-default"><input type="radio" value="1"></label>'
                ;
            //            return Html::tag('span', '', ['class' => "btn-show-hide-{$index} glyphicon glyphicon-eye-open btn btn-info"]).
            //                '<label class="btn btn-default"><input type="radio" value="1"></label>';
        },
        'layoutConfig' => [
            'offsetClass' => '',
            'labelClass' => '',
            'wrapperClass' => 'col-sm-12',
            'errorClass' => 'col-sm-12',
            'buttonActionClass' => 'col-sm-2',
        ],
        'columns' => [
            [
                'name' => "fio",
                'type' => Typeahead::className(),
                'value' => function($data){
                    return $data['fio'];
                },
                'options' => [
                    'options' => ['class' => 'typeahead'],
                    'pluginOptions' => ['highlight' => true],
                    'pluginEvents' => [
                        'typeahead:select' => 'function(e, datum) {
        //                           console.log($(this).attr("id"));
                                   var newid = $(this).attr("id").replace("-fio","-lecture_id");
        //                           alert(datum.id);
                                   $("#"+newid).val(datum.id);
        //                           $(this).closest(".tt-input").data("id",datum.id);

                                 }',
                        //                         'typeahead:render' => 'function(data) { console.log("datarender="); console.log(data); }',
                        //                         'typeahead:active' => 'function(data) { console.log("data1="); console.log(data); }',
                        //                         'typeahead:typeahead:open' => 'function(data) {console.log("data2=");  console.log(data); }',
                    ],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            //'prefetch' => $baseUrl . '/samples/countries.json',
                            'remote' => [
                                'url' => Url::to(['/event/speakers-list']) . '?q=%QUERY',
                                'wildcard' => '%QUERY'
                            ],
//                            'templates' => [
//                                'notFound' => '<div class="text-danger" style="padding:0 8px">'
//                                    .Module::t('module','AUTHORS_NOTFOUND').' '
//                                    .Html::a(Module::t('module','ADD_AUTHOR'),
//                                        ['#'],
//                                        [
//                                            'id'=>'modalauthor',
//                                            'data-url'=>Url::to('/user/author/coauthorcreate')
//                                        ]).
//                                    '</div>',
//                            ]
                        ]
                    ],
                ],
            ],
            [
                //                'name' => 'coauthors["coauthors_id"]',
                'name' => 'lecture_id',
                'type' => 'hiddenInput',
                //                'type' => 'static',
                'value' => function($data){
                    return $data['id'];
                },
            ]
        ],
    ])->label();
    ?>

    <?= $form->field($model, 'eventIdnkomed')->dropDownList($model->eventArray,['prompt' => 'Выбрать ...']) ?>

    <?= $form->field($model, 'urlAlias')->textInput() ?>

    <div class="row">
        <div class="col-12 col-md-3 mb-3">
            <?= $form->field($model, 'duration')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
