<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php if($_GET['slug'] == 'ob-associacii'): ?>

<div class="container-fluid position-relative" style="background: url('/uploads/pages/headbg/1.jpg') no-repeat; background-size: cover;">
<!--    <img src="/uploads/pages/headbg/1.jpg" alt="" class="pageheadbg">-->
    <div class="container ml-auto mr-auto pb-5 pt-5 mb-5">
<!--        <div class="pagetitleblock">-->
            <?php echo $this->render('//layouts/_breadcrumb') ?>
            <h1><?= Html::encode($this->title) ?></h1>
<!--        </div>-->
    </div>
</div>

<div class="container page-view">


    <?php
    if($model->full_text) {
        echo $model->full_text;
    }
    ?>



</div>
