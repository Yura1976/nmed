<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
//use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use unclead\multipleinput\MultipleInput;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data',
        ]]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'access')->dropDownList($model->accessArray,['prompt' => 'Выбрать ...']) ?>
        </div>
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'rule')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'isEventRegAllowed')->radioList(
            $model->isEventRegAllowedArray,
            [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return
                        '<div class="radio"> <label> ' . Html::radio($name, $checked, ['value' => $value]) . $label . '</label></div>';
                },
            ]
        )->label(); ?>

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

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'image')->textInput() ?>
        </div>
        <div class="col-12 col-md-5 mb-3">
            <fieldset>
                <?= $form->field($model, 'imagefile')->fileInput(); ?>
                <?php
                if (!empty($model->imagefile) && $imgurl = \common\models\Common::getFile('/webinar', $model->imagefile, $model->imagefile)) {
                    echo 'Уже загружено ', Html::a('изображение', $imgurl, ['target' => '_blank']);
                }
                ?>
            </fieldset>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'type')->dropDownList($model->typeArray, ['prompt' => 'Выбрать ...']) ?>
        </div>
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'lang')->dropDownList([ 'RU' => 'Русский', 'EN' => 'Английский' ], ['prompt' => 'Выбрать']) ?>
        </div>
    </div>

    <?= $form->field($model, 'urlAlias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lectorIds')->textInput() ?>

<?= $form->field($model, 'speakers')->widget(MultipleInput::className(), [
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
//    echo $form->field($model,'lecture_ids')->hiddenInput()->label(false);
    ?>
    <?php
//    echo $form->field($model, 'speakers')->widget(MultipleInput::className(), [
//        'min' => 1,
//        'max' => 5,
//        'allowEmptyList' => false,
//        'rendererClass' => \unclead\multipleinput\renderers\ListRenderer::className(),
//        'extraButtons' => function ($model, $index, $context) {
//            return '<span class="unclead_span"><a href="#" onclick="return moveChoiceTo(this, -1);"><i class="glyphicon glyphicon-circle-arrow-up"></i></a>
//                        <a href="#" onclick="return moveChoiceTo(this, 1);"><i class="glyphicon glyphicon-circle-arrow-down"></i></a></span>'
//                //                    .'<label class="btn btn-default"><input type="radio" value="1"></label>'
//                ;
//            //            return Html::tag('span', '', ['class' => "btn-show-hide-{$index} glyphicon glyphicon-eye-open btn btn-info"]).
//            //                '<label class="btn btn-default"><input type="radio" value="1"></label>';
//        },
//        'layoutConfig' => [
//            'offsetClass' => '',
//            'labelClass' => '',
//            'wrapperClass' => 'col-sm-12',
//            'errorClass' => 'col-sm-12',
//            'buttonActionClass' => 'col-sm-2',
//        ],
//        'columns' => [
//            [
//                'name' => "fio",
//                //                'title' => Module::t('module','COAUTHORS'),
//                'type' => Typeahead::className(),
//                'value' => function($data){
//                    return $data['fio'];
//                },
//                'options' => [
//                    'options' => ['class' => 'typeahead'],
//                    'pluginOptions' => ['highlight' => true],
//                    'pluginEvents' => [
//                        'typeahead:select' => 'function(e, datum) {
//        //                           console.log($(this).attr("id"));
//                                   var newid = $(this).attr("id").replace("-fio","-coauthors_id");
//        //                           alert(datum.id);
//                                   $("#"+newid).val(datum.id);
//        //                           $(this).closest(".tt-input").data("id",datum.id);
//
//                                 }',
//                        //                         'typeahead:render' => 'function(data) { console.log("datarender="); console.log(data); }',
//                        //                         'typeahead:active' => 'function(data) { console.log("data1="); console.log(data); }',
//                        //                         'typeahead:typeahead:open' => 'function(data) {console.log("data2=");  console.log(data); }',
//                    ],
//                    'dataset' => [
//                        [
//                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                            'display' => 'value',
//                            //'prefetch' => $baseUrl . '/samples/countries.json',
//                            'remote' => [
//                                'url' => Url::to(['/user/author/authorslist']) . '?q=%QUERY',
//                                'wildcard' => '%QUERY'
//                            ],
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
//                        ]
//                    ],
//                ],
//            ],
//            [
//                //                'name' => 'coauthors["coauthors_id"]',
//                'name' => 'coauthors_id',
//                'type' => 'hiddenInput',
//                //                'type' => 'static',
//                'value' => function($data){
//                    return $data['coauthors_id'];
//                },
//            ]
//        ],
//    ])->label(false);
//    echo $form->field($model,'authors_ids')->hiddenInput()->label(false);


//    $btn = '<i class="fas fa-plus-circle" data-from-clone="true" title="Добавить еще"></i>
//            <i class="fas fa-minus-circle"></i>';
//    if(is_array($model->lecture)){
//        foreach ($model->lecture as $item){
//
//        }
//    } else{
//        $id = 's'.mb_strtolower(Yii::$app->security->generateRandomString(12));
//        echo $form->field($model, 'lecture['.$id.'][lecture]',['options'=>['class'=>'col-12'],
//            'addon'=>[
//                    'append' => ['content'=>'
//                    <i class="fas fa-plus-circle" data-from-clone="true" title="Добавить еще"></i>
//                    <i class="fas fa-minus-circle" data-from-remove="true" title="Удалить"></i>
//                    '],
////                'prepend'=>['content'=>]
//            ]
//        ]);
//    }

    ?>

    <?= $form->field($model, 'eventcategoryids')->widget(Select2::classname(), [
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
    ])->label(false); ?>

    <?= $form->field($model, 'additionalFields')->textInput() ?>

    <?= $form->field($model, 'tags')->textInput() ?>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12 col-md-5">
            <?= $form->field($model, 'ownerId')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-5">
        <?= $form->field($model, 'defaultRemindersEnabled')
                ->dropDownList($model->defaultRemindersEnabledArray, ['prompt' => 'Выбрать ...'])
                ->label('Стандартные напоминания (включить напоминания за 1 ч и за 15 минут)'); ?>
        </div>
    </div>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить и создать вебинар', ['id' => 'btnCreateWebinar', 'class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Сохранить', ['id' => 'btnCreate', 'class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$this->registerJs("
    $('body').on('click','[data-from-clone]',function(e){
        var el = $(this).closest('.input-group');
        var data = el.clone();
        data.find('input[type=\"hidden\"]').remove();
//        data.find('[data-from-contact]').removeClass('text-primary');
        var data_input = data.find('input');
        var help = el.siblings('.help-block');
//        var rand_id = Math.random().toString(36).substr(2);
//        data_input.attr('id',rand_id).attr('name','Office[phone]['+rand_id+'][lecture]');
        help.before(data);
    }).on('click','[data-from-remove]',function(){
        $(this).closest('.input-group').remove();
    });

");
?>