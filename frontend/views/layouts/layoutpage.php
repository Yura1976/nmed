<?php

/* @var $this \yii\web\View */
/* @var $content string */

?>

<?php $this->beginContent('@frontend/views/layouts/main.php',['nobreadcrumb'=>true]); ?>

<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div id="mainContent" class="col-sm-12">-->
            <?= $content ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<?php $this->endContent(); ?>
