<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use \common\models\Config;

/* @var $this yii\web\View */
/* @var $model common\models\Webinar */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Вебинары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="webinar-view">
    <div class="webinar-info">
        <?php if($model->startsAt): ?>
            <span class="data"><span class="webinar-icons data-icon"></span><?=$model->startsAt?></span>
        <?php endif; ?>
        <?php if($model->duration): ?>
            <span class="duration"><span class="webinar-icons duration-icon"></span><?=$model->duration?> мин</span>
        <?php endif; ?>
        <span class="webinar-type"><span class="webinar-icons webinartype-icon"></span><?=$model->typeName?></span>
    </div>
    <div class="mt-4 mb-4">
        <p class="webinar-category"><?php echo $model->getCategoryList()?></p>
    </div>
    <div class="mb-4">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="mb-5">
        <?php if (Yii::$app->user->isGuest): ?>
            <?=Html::a('Записаться',['/user/auth','formtype'=>'signin'],['class'=>'btn btn-blue blue btn100 mt-4 mr-4 auth-link', 'data-toggle'=>"modal", 'data-target'=>"#modal"])?>
        <?php else: ?>
            <?=Html::a('Записаться',['#'],['id'=>'webinarorder', 'data-toggle'=>"modal", 'data-url'=>Url::to(['webinar/order','id'=>$model->id]), 'data-target'=>"#modal", 'class'=>'btn btn-blue blue btn100 mt-4 modallink'])?>
        <?php endif; ?>
        <?=Html::a('Пригласить коллегу +'.Config::getConfig(9).'zn',['#'],['id'=>'','class'=>'btn btn-outline-blue blue btn100 mt-4'])?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9">
                <?php if($model->description): ?>
                <?php echo $model->description; ?>
                <?php endif; ?>
                <div class="mt-5 mb-5">

                    <?php if (Yii::$app->user->isGuest): ?>
                        <?=Html::a('Записаться',['/user/auth','formtype'=>'signin'],['class'=>'btn btn-outline-blue blue btn100 mt-4 mr-4 auth-link', 'data-toggle'=>"modal", 'data-target'=>"#modal"])?>
                    <?php else: ?>
                        <?=Html::a('Записаться',['#'],['id'=>'webinarorder', 'data-toggle'=>"modal", 'data-url'=>Url::to(['webinar/order','id'=>$model->id]), 'data-target'=>"#modal", 'class'=>'btn btn-outline-blue blue btn100 mt-4 modallink'])?>
                    <?php endif; ?>

                </div>
            </div>
            <div class="article-speaker col-12 col-md-3 text-center">
                <div class="speaker">
                    <div<?php if(count($model->speakers)>1){ echo ' id="slick'.$model->id.'" class="webinar-speaker-slick-slider"';}?>>

                            <div>
                                <?php $j=1; foreach($model->speakers as $speaker): ?>
                                    <div class="mb-4 overflow-hidden<?php if($j==1) echo ' active'?>">
                                        <div class="webinar-speaker-info d-block w-100 text-left overflow-hidden">
                                            <?php if($speaker->getAvatar()): ?>
                                                <img src="<?=$speaker->getAvatar()?>" alt="<?=$speaker->fio?>" class="speaker-ava img-fluid rounded-circle float-left mr-3">
                                            <?php endif;?>
                                            <div class="overflow-hidden">
                                                <p class="fio text-left"><?=$speaker->fio?></p>
                                                <p class="speaker-info mt-0 text-left"><?=$speaker->getSpeakerInfo()?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $j++; endforeach; ?>
                            </div>

                    </div>
                </div><!--./.speaker.card-footer-->


            </div>
        </div>
    </div>



</div>
