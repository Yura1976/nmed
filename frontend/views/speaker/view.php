<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Speaker */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Лекторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="speaker-view">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="row mt-5">
    <div class="col-sm-12 col-md-2 pr-md-4 speaker-img text-left">
        <?php if($ava = $model->getAvatar()): ?>
            <img src="<?=$ava?>" alt="<?=$model->fio?>" class="img-fluid rounded-circle">
        <?php endif; ?>
    </div>
    <div class="col-sm-12 col-md-10">
        <div><?=$model->getAttributeLabel('education_id')?>: <?=$model->education->name ?></div>
        <div><?=$model->getAttributeLabel('academicdegree_id')?>: <?=$model->academicdegree->name ?></div>
        <div><?=$model->getAttributeLabel('work_place')?>: <?=$model->work_place ?></div>
        <div><?=$model->description ?></div>
    </div>
</div>

</div>
