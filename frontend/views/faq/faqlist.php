<?php
use yii\helpers\Html;

?>

<?php foreach ($model as $faq): ?>
    <div class="questions">
        <p class="question pt-3"><span> + </span> <?=Html::a($faq->question,['faq/view','slug'=>$faq->slug])?></p>
    </div>
<?php endforeach; ?>

