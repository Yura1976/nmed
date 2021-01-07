<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регионы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-index">

    <p>
        <?= Html::a('Добавить регион', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

<?php
$this->registerJsFile('@web/js/jstree.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/js/themes/default/style.min.css', ['depends' => [yii\web\JqueryAsset::class]]);
?>

    <div id="explorer"></div>
    <?php

    $this->registerJs("
    $('#explorer').jstree({
        'core': {
            'data' : {
                'url' : '" . Url::to(['tree', 'all' => true]) . "',
                'data' : function (node) {
                    return {'id': node.id};
                }
            },
            'check_callback' : true,
        },
//         'contextmenu':{         
//            'items': function(node) {
//                var tree = $('#explorer').jstree(true);
//                return {
//                    'Create': {
//                        'label': 'Добавить дочернюю',
//                        'icon': 'fa fa-plus-circle',
//                        'action': function (obj) { 
//                            node = tree.create_node(node);
//                        }
//                    },
//                    'Rename': {
//                        'label': 'Переименовать',
//                        'icon': 'fas fa-edit',
//                        'action': function (obj) { 
//                            tree.edit(node);
//                        }
//                    },                         
//                    'Remove': {
//                        'label': 'Удалить',
//                        'icon': 'fas fa-trash-alt',
//                        'action': function (obj) { 
//                            tree.delete_node(node);
//                        }
//                    }
//                };
//            }
//        },
        'state' : { 'key' : 'state_demo' },
        'plugins' : [
            'contextmenu', 
            'dnd', 
            'state',
            'search',
//            'types',
            'wholerow'
//            'types' // При этом жутко тормозит создание ноды
        ]
    }).on('create_node.jstree', function(event, data) {
//        console.log(data);
        $.post(
            '" . url::to(['/region/create-node']) . "',
            {parent: data.node.parent, name: data.node.text},
            function(response){
                if(response.status == 'success') {
                    $('#explorer').jstree(true).set_id(data.node, response.id);
                    $('#explorer').jstree(true).edit(data.node);
                }
                else {
                console.log('error');
                }
            }
        );
    }).on('rename_node.jstree', function(event, data) {
        $.post(
            '" . url::to(['/region/rename-node']) . "',
            {id: data.node.id, name: data.node.text},
            function(data){}
        );
    }).on('delete_node.jstree', function(event, data) {
        $.post(
            '" . url::to(['/region/delete-node']) . "',
            {id: data.node.id},
            function(data){}
        );
    })
//    .on('move_node.jstree', function(event, data) {
//        $.post(
//            '" . url::to(['/category/move-node']) . "',
//            {
//                id: data.node.id,
//                prev_id: $('#' + data.node.id).prev().attr('id'),
//                parent_id: data.node.parent
//            },
//            function(data){}
//        );
//    })
    ;
");

 ?>
    <?php
//    echo \yii\helpers\Url::to(['tree']);
//    echo \yiidreamteam\jstree\JsTree::widget([
//        'containerOptions' => [
//            'class' => 'data-tree',
//        ],
//        'jsOptions' => [
//            'core' => [
//                'multiple' => false,
//                'data' => [
//                    'url' => \yii\helpers\Url::to(['tree']),
//                    'data' => function (node) {
//                        return ['id' => node.id];
//                    }
//                ],
//                'themes' => [
//                    'name' => 'foobar',
//                    'url' => "/themes/foobar/js/jstree3/style.css",
//                    'dots' => true,
//                    'icons' => false,
//                ]
//            ],
//        ]
//    ])
    ?>
    <?php
    //    echo ListView::widget([
//        'dataProvider' => $dataProvider,
//        'itemOptions' => ['class' => 'item'],
//        'itemView' => function ($model, $key, $index, $widget) {
//            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
//        },
//    ])
    ?>

    <?php //Pjax::end(); ?>

</div>
