<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">
    <div class="article-header">
        <div class="mb-4 mt-4"><span class="data"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14.4141 10.3125C14.7377 10.3125 15 10.0502 15 9.72656V3.51562C15 2.22328 13.9486 1.17188 12.6562 1.17188H11.8945V0.585938C11.8945 0.262324 11.6322 0 11.3086 0C10.985 0 10.7227 0.262324 10.7227 0.585938V1.17188H8.05664V0.585938C8.05664 0.262324 7.79432 0 7.4707 0C7.14709 0 6.88477 0.262324 6.88477 0.585938V1.17188H4.24805V0.585938C4.24805 0.262324 3.98572 0 3.66211 0C3.3385 0 3.07617 0.262324 3.07617 0.585938V1.17188H2.34375C1.05141 1.17188 0 2.22328 0 3.51562V12.6562C0 13.9486 1.05141 15 2.34375 15H12.6562C13.9486 15 15 13.9486 15 12.6562C15 12.3326 14.7377 12.0703 14.4141 12.0703C14.0904 12.0703 13.8281 12.3326 13.8281 12.6562C13.8281 13.3024 13.3024 13.8281 12.6562 13.8281H2.34375C1.69758 13.8281 1.17188 13.3024 1.17188 12.6562V3.51562C1.17188 2.86945 1.69758 2.34375 2.34375 2.34375H3.07617V2.92969C3.07617 3.2533 3.3385 3.51562 3.66211 3.51562C3.98572 3.51562 4.24805 3.2533 4.24805 2.92969V2.34375H6.88477V2.92969C6.88477 3.2533 7.14709 3.51562 7.4707 3.51562C7.79432 3.51562 8.05664 3.2533 8.05664 2.92969V2.34375H10.7227V2.92969C10.7227 3.2533 10.985 3.51562 11.3086 3.51562C11.6322 3.51562 11.8945 3.2533 11.8945 2.92969V2.34375H12.6562C13.3024 2.34375 13.8281 2.86945 13.8281 3.51562V9.72656C13.8281 10.0502 14.0904 10.3125 14.4141 10.3125Z" fill="#282828"/>
<path d="M7.5 11.6602C7.82361 11.6602 8.08594 11.3978 8.08594 11.0742V6.26953C8.08594 6.04594 7.95867 5.8418 7.7579 5.74342C7.5571 5.64498 7.3178 5.66941 7.14108 5.80641L5.96921 6.71461C5.71345 6.91283 5.66678 7.28089 5.865 7.53668C6.06322 7.79244 6.43125 7.83911 6.68707 7.64089L6.91409 7.46496V11.0742C6.91406 11.3978 7.17639 11.6602 7.5 11.6602Z" fill="#282828"/>
</svg> &nbsp;<?=$model->data_show?></span></div>
        <h2><?=$model->name?></h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9">
                <h3 class="mb-4 mt-4"><?=$model->subtitle?></h3>
                <?php if (!empty($model->annot_text)): ?>
                <div><?=$model->annot_text?></div>
                <?php endif; ?>
                <?php if (!empty($model->detail_text)): ?>
                <div><?=$model->detail_text?></div>
                <?php endif; ?>
            </div>
            <div class="article-speaker col-12 col-md-3 text-center">
                <?php foreach ($model->authorArray as $item): ?>
                    <div>
                        <?php if($ava = $item->getAvatar()): ?>
                            <img src="<?=$ava?>" alt="<?=$item->fio?>" class="img-fluid rounded-circle mx-auto d-block ava">
                        <?php endif; ?>
                        <h5 class="mt-3 mb-3"><?php echo $item->getFio()?></h5>
                        <div>
                            <?=$item->getAuthorInfo();?>
                        </div>

                    </div>
                <?php endforeach; ?>


            </div>
        </div>
    </div>
</div>
