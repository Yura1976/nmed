<?php
use yii\helpers\Html;
?>

<div>
    <?php
    foreach ($model as $item) {
        var_dump($item);
    }
    ?>
<!--    --><?//=Html::a(Html::encode($model->question), ['view', 'slug' => $model->slug]);?>
</div>

