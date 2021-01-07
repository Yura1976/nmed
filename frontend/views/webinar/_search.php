<?php

use yii\helpers\Html;
//use yii\bootstrap4\ActiveForm;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\search\WebinarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webinar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'tooltipStyleFeedback' => true,
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'webinarcategoryids')->widget(Select2::class, [
                'data' => $model->getCategoryArray(),
        //        'value' => 1,
                'language' => Yii::$app->language,
                'options' => [
                    'multiple' => false,
                    'placeholder' => $model->getAttributeLabel('webinarcategoryids')
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>
        </div>
        <div class="col-sm-3">
            <?php
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'from_date',
                'attribute2' => 'to_date',
                'options' => ['placeholder' => 'Дата, от'],
                'options2' => ['placeholder' => 'до'],
                'type' => DatePicker::TYPE_RANGE,
                'form' => $form,
                'separator' => ' - ',
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose' => true,
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'searchworld')
                ->textInput([
                        'placeholder'=>$model->getAttributeLabel('searchworld')
                ])->label(false) ?>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
                <?php //echo Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
