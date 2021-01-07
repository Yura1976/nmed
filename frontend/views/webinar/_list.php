<?php
use \yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="col-12 mb-5 d-flex item">
<!--    <div class="nevro card border-0 bg-transparent" style="background: url('/uploads/webinar/e56dee477b97588c6fa49ceff20ab3f6.jpg')">-->
    <div class="card border-0 w-100<?=$model->getCssclass()?>">
        <div class="webinar-info">
                <?php if($model->startsAt): ?>
                <span class="data"><span class="webinar-icons data-icon"></span><?=$model->startsAt?></span>
                <?php endif; ?>
                <?php if($model->duration): ?>
                <span class="duration"><span class="webinar-icons duration-icon"></span><?=$model->duration?> мин</span>
                <?php endif; ?>
                <span class="webinar-type"><span class="webinar-icons webinartype-icon"></span><?=$model->typeName?></span>
        </div>
        <div class="card-body">
            <p class="webinar-category"><?php echo $model->getCategoryList()?></p>
            <p class="webinar-title"><?=Html::a($model->name,['webinar/view','slug'=>$model->slug])?></p>
        </div>
        <div class="speaker webinar-card-footer">
                <div<?php if(count($model->speakers)>1){ echo ' id="carousel'.$model->id.'" class="carousel slide overflow-hidden" data-ride="carousel"';}?>>
                    <div>
                        <div<?php if(count($model->speakers)>1){ echo ' class="slider"'; } ?>>
                            <?php $j=1; foreach($model->speakers as $speaker): ?>
                            <div class="<?php if(count($model->speakers)>1){ echo ' carousel-item ';}?>overflow-hidden<?php if($j==1) echo ' active'?>">
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
                        <?php  if(count($model->speakers)>1): ?>
                        <a class="carousel-control-prev" href="#carousel<?=$model->id?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Назад</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel<?=$model->id?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Вперед</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-left">
                <?php if (Yii::$app->user->isGuest): ?>
                    <?=Html::a('Записаться',['/user/auth','formtype'=>'signin'],['class'=>'btn btn-outline-blue blue btn100 mt-4 auth-link', 'data-toggle'=>"modal", 'data-target'=>"#modal"])?>
                <?php else: ?>
                    <?=Html::a('Записаться',['#'],['id'=>'webinarorder', 'data-toggle'=>"modal", 'data-url'=>Url::to(['webinar/order','id'=>$model->id]), 'data-target'=>"#modal", 'class'=>'btn btn-outline-blue blue btn100 mt-4 modallink'])?>
                <?php endif; ?>
                </div>
            </div><!--./.speaker.card-footer-->
        </div><!--./.h-100-->
<!--        <img class="item-bg" src="/uploads/webinar/category/brain.svg" alt="Неврология">-->
    <!--</div>./.nevro.flex-fill-->
</div><!--./.col-sm-6.d-flex.item-->