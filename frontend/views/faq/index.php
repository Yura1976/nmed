<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вопросы-ответы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-index mb-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php foreach ($dataProvider->getModels() as $model) : ?>
    <?php if(isset($model->name)): ?>
            <h4><?=$model->name?></h4>
            <?php if(!empty($model->faqs)): ?>
                <?php echo $this->render('faqlist',['model'=>$model->faqs])?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>


    <?php Pjax::end(); ?>

</div>
