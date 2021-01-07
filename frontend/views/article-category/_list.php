<?php

use yii\helpers\Html;
use yii\widgets\ListView;

?>
<div class="category-title mt-3 mb-3">
    <div class="d-flex justify-content-between">
        <h2><?=Html::encode($model->name)?></h2>
        <div><?=Html::a('Смотреть другие статьи',['/article-category/index','slug'=>$model->slug],['class'=>'btn btn100 btn-outline-blue'])?></div>
    </div>
</div>
<div class="row align-items-stretch b-height">
<?php
//$n = 0;
//echo "<div><strong>".$model->id." ".$model->name."</strong></div>";
////var_dump($data[$model->id]);
//foreach ($data[$model->id] as $item){
//    echo "<div class='d-block'>".$item->id." ".$item->name."</div>";
//}
//foreach ($data as $datum) {
//    echo "<br>".$datum["category"]["id"]." ".$datum["category"]["name"];
//}

if(count($model->articles) == 0){
    ?>
        <div>В разделе нет статей</div>
    <?php
}
//foreach ($model->articles as $article) {
foreach ($data[$model->id] as $article) {
?>
<div class="article-item col-sm-12 col-md-6 col-lg-4 g">
    <?php echo \Yii::$app->view->renderFile(
            '@app/views/article/_list.php',[
                'category'=>$model,
                'model'=>$article
            ]); ?>
</div>
<?php
//    if($n == 2) break;
//    $n++;
}
?>
</div>