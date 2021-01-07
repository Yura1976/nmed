<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $profile common\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="profile-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype'=>'multipart/form-data',
//                'data-pjax' => true,
                'id' => 'ProfileForm4',
                'class' => 'profileform'
            ],
            'action' => Url::to(['profile/ajax-profile-update'])
        ]); ?>

        <div class="row">
            <div class="col-12">
                <h4>Настройки рассылки</h4>
                <p>Пожалуйста, укажите способы получения рассылки</p>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <?php
                $ischecked = ($profile->subscribingids)?" checked" : "";
                echo $form->field($profile, 'subscribingids',
                    ['labelOptions' => ['class' => 'control-label cursor-pointer']])
                    ->inline(true)
                    ->checkboxList(
                        ArrayHelper::map(
                            \common\models\SubscribingType::find()
                                ->where(['status'=>1])
                                ->all(), 'id', 'name'
                        ),
                        [
                            'itemOptions' => [
                                'class' => 'custom-control-input subscribe',
                            ]
                        ]
                    )->label('<input type="checkbox" id="checkAll"'.$ischecked.'> Выбрать все');
                ?>
                <?php
                //            $form->field($profile, 'subscribingids')->widget(Select2::classname(), [
                //                'data' => \common\models\SubscribingType::getSubscribingArray(),
                //                'bsVersion' => '4.x',
                //                'options' => [
                //                    'multiple' => true,
                //                    'placeholder' => 'Выберите способы получения рассылки'
                //                ],
                //                'pluginOptions' => [
                //                    'allowClear' => true
                //                ],
                //            ])->label(false);
                ?>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['id' => 'profileformbtn4', 'class' => 'btn btn-outline-blue profileformbtn']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
