<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArticleCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">
<?php
//foreach ($data as $items) {
//    foreach($items as $item) {
//        echo "<div>id= " . $item['id'] . " " . $item['name'] . "</div>";
//    }
//}

?>
    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
        'viewParams' => ['data' => $data],
        'layout' => "{items}\n{pager}",
        'options' => [
            'tag' => 'div',
            'class' => 'news-list',
            'id' => 'news-list',
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'news-item mt-4 mb-4',
        ],
    ]) ?>

    <?php Pjax::end(); ?>

</div>
