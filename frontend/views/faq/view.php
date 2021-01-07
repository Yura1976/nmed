<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Faq */

$this->title = $model->question;
$this->params['breadcrumbs'][] = ['label' => 'Часто задаваемые вопросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="faq-view mb-5">

    <h1 class="mt-4 mb-4"><?= Html::encode($this->title) ?></h1>
    <?php if(isset($model->answer)): ?>
    <div>
        <?=$model->answer?>
    </div>
    <?php endif; ?>

    <div>
        <h4>Другие вопросы</h4>
        <div>
            <?php echo $this->render('faqlist',['model'=>$dataProvider->getModels()])?>
        </div>
    </div>
    <div class="morequestions mt-5 pt-5 pb-5 pl-5 text-left">

        <h3 class="ml-0">У вас остались вопросы?</h3>
        <p>Задайте их нам по форме обратной связи</p>
        <?php if($config = \common\models\Config::getConfig(8)): ?>
            <p><a href="mailto:<?=$config?>" class="btn btn-blue mt-4 btn100">Задать вопрос</a></p>
        <?php endif; ?>
    </div>


</div>
