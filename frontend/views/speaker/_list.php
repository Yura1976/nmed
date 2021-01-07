<?php

use yii\helpers\Html;

?>
<div class="speaker card mt-4 mb-4 mr-auto ml-auto border-0">
    <div class="speaker-img card-img">
        <?php if(($ava = $model->getAvatar()) !== false): ?>
            <img src="<?=$ava?>" alt="<?=$model->fio?>" class="img-fluid rounded-circle">
        <?php endif; ?>
    </div>
    <div class="card-body border-0 pt-0 pb-0"></div>
    <div class="card-footer border-0 bg-white align-top">
        <div class="item-link text-center align-top"><?=Html::a($model->fio, ['/speaker/view','slug'=>$model->slug])?></div>
    </div>
</div>
