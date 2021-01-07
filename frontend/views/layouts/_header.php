<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Menu;
use yii\bootstrap4\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\alert\Alert;
use \yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container">
    <header>
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-sm-4 pt-1 logo">
                <a href="/"><img src="/images/logo.png" class="img-fluid float-left" alt="<?=Yii::$app->name?>"  title="<?=Yii::$app->name?>">
                    Межрегиональный центр<br>развития профессионального<br>медицинского образования</a>
            </div>
            <div class="col-sm-8">
                <div class="d-flex justify-content-between">
                    <div class="pt-3"><i class="far fa-envelope"></i> <a href="mailto:info@nkomed.ru">info@nkomed.ru</a></div>
                    <div class="pt-3"><i class="fas fa-phone-volume"></i> +7(918) 206-36-58 </div>
                    <div class="text-center pt-3">
                        <?=Html::a('<i class="fab fa-facebook-f"></i>','#')?>
                        <?=Html::a('<i class="fab fa-vk"></i>','#')?>
                    </div>
                    <div>
                        <nav id="w0" class="navbar navbar-expand navbar-light lg-light">
                            <ul class="navbar-nav">
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <li><i class="fab fa-expeditedssl pt-3"></i></li>
                                    <li class="nav-item">
                                        <?=Html::a('Зарегистрироваться',['/user/signup'],['class'=>'nav-link'])?>
                                    </li>
                                    <li class="nav-item">
                                        <?=Html::a('Войти',['/user/login'],['class'=>'nav-link'])?>
                                    </li>
                                <?php } else { ?>
                                    <li class="dropdown show">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            useravatar
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <?=Html::a('Профиль',['/profile/update'],['class'=>"dropdown-item"])?>
                                            <?=Html::a('Личная информация',['/user/security'],['class'=>"dropdown-item"])?>
                                        </div>
                                    </li>
                                    <li class="dropdown show">
                                        <a id="dropdownSubMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle" title="бонусы">
                                            <i class="far fa-bell"></i>
                                            <span class="badge badge-warning navbar-badge">15</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="dropdownSubMenu2">
                                            <span class="dropdown-header">15 Notifications</span>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                                                <span class="float-right text-muted text-sm">3 mins</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-users mr-2"></i> 8 friend requests
                                                <span class="float-right text-muted text-sm">12 hours</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-file mr-2"></i> 3 new reports
                                                <span class="float-right text-muted text-sm">2 days</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <?=Html::a('Выйти',['/user/logout'],['class'=>'nav-link','data' => ['method' => 'post',]])?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
<div class="topnav">
    <?php
    NavBar::begin([
        'brandLabel' => false,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-dark navbar-expand-lg navbar',
        ],
    ]);
    $menuItems = [
        ['label' => 'Календарь мероприятий', 'url' => ['/webinar/index'],['class'=>'p-2']],
        ['label' => 'Вебинары', 'url' => ['/webinar/index'],['class'=>'p-2']],
        ['label' => 'Лекторы', 'url' => ['/speaker/index'],['class'=>'p-2']],
        ['label' => 'Статьи', 'url' => ['/article/index'],['class'=>'p-2']],
        ['label' => 'Вопросы-ответы', 'url' => ['/faq/index'],['class'=>'p-2']],
        [
            'label' => 'Бонусы',
            'url' => ['#'],
            'items' => [
                [
                    'label' => 'Бонусная программа',

                    'url' => ['/page/view','slug'=>'bonusnaya-programma'],
                ],
                [
                    'label' => 'Как копить бонусы',
                    'url' => ['/page/view','slug'=>'kak-kopit-bonusy'],
                ],
                [
                    'label' => 'Как получить (обналичить) бонусы',
                    'url' => ['/page/view','slug'=>'kak-poluchit-obnalichit-bonusy'],
                ],
                [
                    'label' => 'Бонусный статус, 3-4 ступени бонусного накопления',
                    'url' => ['/page/view','slug'=>'bonusnyy-status-3-4-stupeni-bonusnogo-nakopleniya'],
                ],
            ],
            [
                'class'=>'p-2'
            ]
        ],
        ['label' => 'Ассоциация', 'url' => ['/page/view','slug'=>'ob-associacii'],['class'=>'p-2']],
        ['label' => 'Контакты', 'url' => ['#'],['class'=>'p-2']],
    ];
    echo Nav::widget([
        'options' => [
            'id'=>'topmenu',
            'class' => 'navbar-nav d-flex justify-content-between'
        ],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
</div>
<?php if(Url::home() == Yii::$app->request->url): ?>
    <div class="banner">
        <div class="container">
            <div class="w-60 banner-content">
                <p class="banner-title1">При поддержке Ассоциации врачей<br>амбулаторно-поликлинического звена</p>
                <h1>Межрегиональный центр развития профессионального медицинского образования</h1>
                <p class="banner-slogan left-blue">Онлайн образование для врачей<br>
                    Учитесь, развивайтесь, зарабатывайте
                </p>
                <p><?=Html::a('Регистрация',['/user/signup'],['class'=>'btn btn100 btn-blue'])?></p>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <ul>
                    <li><a href="#" style="text-decoration: underline; font-weight: bold">Моя анкета</a></li>
                    <li><a href="#">Мои вебинары</a></li>
                    <li><a href="#">Мои бонусы</a></li>
                    <li><a href="#">Пригласи коллег</a></li>
                </ul>
                <ul>
                    <li><a href="#">Сменить пароль</a></li>
                    <li><a href="#">Выход</a></li>
                </ul>
            </div>
            <div class="col-sm-9">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
