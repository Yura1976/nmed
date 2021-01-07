<?php

/* @var $this \yii\web\View */
/* @var $content string */

?>

<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div class="container mt-5">
    <div class="row">
        <div id="mainContent" class="col-sm-9">
             <?= $content ?>
        </div>
        <div class="col-sm-3 sidebar">
            <ul class="navbar-nav pt-3 pb-3">
                <li class="active"><a href="#">Моя анкета</a></li>
                <li><a href="#">Мои вебинары</a></li>
                <li><a href="#">Мои бонусы</a></li>
                <li><a href="#">Пригласи коллег</a></li>

                <li><a href="#">Сменить пароль</a></li>
                <li><a href="#">Выход</a></li>
            </ul>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>
