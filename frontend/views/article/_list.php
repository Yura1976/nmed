<?php
use \yii\helpers\Html;
?>
<div class="article card mt-4 mb-4 border-0">
    <div class="article-img card-img">
        <?php if ($img = $model->getImg($model->annonce_img)): ?>
        <img src="<?=$img?>" alt="">
        <?php endif; ?>
    </div>
    <div class="article-inner card-body">
        <div class="article-info">
            <div><span><?=($category !== null && $category->name) ? $category->name : ''?></span><span>&bull;</span><span class="article-data"><?=$model->dataArticle?></span></div>
        </div>
        <div class="article-title"><?=$model->name?></div>
    </div>
    <div class="card-footer border-0">
        <div class="read"><?=Html::a('Читать', ['/article/view','slug'=>$model->slug])?></div>
    </div>
</div>