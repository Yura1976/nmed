<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use unclead\multipleinput\MultipleInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $profile common\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data',
//            'data-pjax' => true,
            'id' => 'ProfileForm2',
            'class' => 'profileform'
        ],
        'action' => Url::to(['profile/ajax-profile-update'])
    ]); ?>


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
    <div class="col-10">
        <?= $form->field($profile, 'specialtyids')->widget(Select2::classname(), [
//            'initValueText' => $profile->newcompany->name_ru,
//        'theme' => Select2::THEME_BOOTSTRAP,
//        'value' => [6,1],
//            'data' => common\models\Specialty::getSpecialtyArray(),
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
                    'url' => Url::to(['/profile/specialty-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(specialty) { return specialty.text; }'),
                'templateSelection' => new JsExpression('function (specialty) { return specialty.text; }'),
            ],
        ]);


        //        echo $form->field($profile, 'specialtyids')->widget(MultipleInput::className(), [
//            'max' => 10,
//            'addButtonOptions' => [
//                'class' => 'btn btn-success',
//                'label' => '<i class="fas fa-plus"></i>' // also you can use html code
//            ],
//            'removeButtonOptions' => [
//                'class' => 'btn btn-danger',
//                'label' => '<i class="fas fa-times-circle"></i>'
//            ],
//            'columns' => [
//                [
//                    'name'  => 'specialty_id',
//                    'title' => $profile->getAttributeLabel('specialtyids'),
//                    'type'  => Typeahead::className(),
//                    'title' => 'Специальность',
//                    'options' => [
//                        'options' => ['class' => 'typeahead'],
//                        'pluginOptions' => ['highlight' => true],
//                        'pluginEvents' => [
//                            'typeahead:select' => 'function(e, datum) {
////                           console.log($(this).attr("id"));
//                           var newid = $(this).attr("id").replace("-fio","-coauthors_id");
////                           alert(datum.id);
//                           $("#"+newid).val(datum.id);
////                           $(this).closest(".tt-input").data("id",datum.id);
//
//                         }',
////                         'typeahead:render' => 'function(data) { console.log("datarender="); console.log(data); }',
////                         'typeahead:active' => 'function(data) { console.log("data1="); console.log(data); }',
////                         'typeahead:typeahead:open' => 'function(data) {console.log("data2=");  console.log(data); }',
//                        ],
//                        'dataset' => [
//                            [
//                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                                'display' => 'value',
//                                //'prefetch' => $baseUrl . '/samples/countries.json',
//                                'remote' => [
//                                    'url' => Url::to(['/adminpanel/specialty/specialtylist']) . '?q=%QUERY',
//                                    'wildcard' => '%QUERY'
//                                ],
////                                    'templates' => [
////                                        'notFound' => '<div class="text-danger" style="padding:0 8px">'
////                                            .Module::t('module','AUTHORS_NOTFOUND').' '
////                                            .Html::a(Module::t('module','ADD_AUTHOR'),
////                                                ['#'],
////                                                [
////                                                    'id'=>'modalauthor',
////                                                    'data-url'=>Url::to('/admin/user/author/coauthorcreate')
////                                                ]).
////                                            '</div>',
////                                    ]
//                            ]
//                        ],
//                    ],
//                ],
//                [
//                    'name'  => 'doc_data',
//                    'type'  => \kartik\date\DatePicker::className(),
//                    'title' => 'Дата документа',
//                    'value' => function($data) {
//                        return $data['day'];
//                    },
////                        'items' => [
////                            '0' => 'Saturday',
////                            '1' => 'Monday'
////                        ],
//                    'options' => [
//                        'pluginOptions' => [
//                            'format' => 'dd.mm.yyyy',
//                            'todayHighlight' => true,
//                            'changeMonth' => true,
//                            'changeYear' => true,
////                                'showButtonPanel' => true,
//                        ]
//                    ]
//                ]
//            ]
//        ])->label(false);
        ?>
    </div>





    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['id' => 'profileformbtn2', 'class' => 'btn btn-outline-blue profileformbtn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
