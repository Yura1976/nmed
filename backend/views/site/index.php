<?php
$this->title = 'Администрирование сайта';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <h3>Зарегистрированные пользователи</h3>
            <p>Всего / за последние сутки: </p>
        </div>
        <div class="col-6">
            <h3>Зарегистрированные на вебинары</h3>
            <p>Всего / за последние сутки: </p>
        </div>
        <div class="col-6">
            <h3>Статьи</h3>
            <p>Всего / за последние сутки: </p>
        </div>
        <div class="col-6">
            <h3>Вебинары</h3>
            <p>Всего / за последние сутки: </p>
        </div>
        <div class="col-lg-6">
            <?php
//            \hail812\adminlte3\widgets\Alert::widget([
//                'type' => 'success',
//                'body' => '<h3>Congratulations!</h3>',
//            ])
            ?>
            <?php
//            \hail812\adminlte3\widgets\Callout::widget([
//                'type' => 'danger',
//                'head' => 'I am a danger callout!',
//                'body' => 'There is a problem that we need to fix. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.'
//            ])
            ?>
        </div>
    </div>
</div>