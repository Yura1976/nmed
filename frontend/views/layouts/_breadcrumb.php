<?php
use yii\bootstrap4\Breadcrumbs;
use common\widgets\alert\Alert;
?>

<?= Breadcrumbs::widget([
    'homeLink' => [
        'label' => '<i class="homeurl"></i> ',
        'encode' => false,
        'url' => Yii::$app->homeUrl,
        'title' => 'Главная',
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => ['class' => 'breadcrumb mt-4'],
]) ?>
<?= Alert::widget() ?>