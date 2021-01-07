<?php

use yii\helpers\Html;
use klisl\nestable\Nestable;
use yii\helpers\Url;

/* @var $query \yii\db\ActiveQuery */

$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-index">

    <p><?= Html::a('Новый пункт меню', ['create'], ['class' => 'btn btn-default']) ?></p>

    <?= Nestable::widget([
        'type' => Nestable::TYPE_WITH_HANDLE,
        'query' => $query,
        'modelOptions' => [
            'name' => 'name',
        ],
        'pluginEvents' => [
            'change' => 'function(e) {}',
        ],
        'pluginOptions' => [
            'maxDepth' => 3,
        ],
        'update' => Url::to(['menu/update']),
        'delete' => Url::to(['menu/delete']),
        'viewItem' => Url::to(['menu/view']),
    ]);
    ?>

    <div id="nestable-menu">
        <button class="btn btn-default" type="button" data-action="expand-all">Expand All</button>
        <button class="btn btn-default" type="button" data-action="collapse-all">Collapse All</button>
    </div>

</div>