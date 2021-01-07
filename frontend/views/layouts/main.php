<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\alert\Alert;
use \yii\helpers\Url;
use \common\models\Config;
use \common\models\Menu;
use \yii\bootstrap4\Modal;

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
                    <?php if(Yii::$app->request->url !== Yii::$app->homeUrl): ?>
                    <a href="/"><img src="/images/logo.svg" class="img-fluid float-left" alt="<?=Yii::$app->name?>"  title="<?=Yii::$app->name?>">
                        <span class="d-none d-lg-block">Межрегиональный центр<br>развития профессионального<br>медицинского образования</span></a>
                    <?php else: ?>
                        <img src="/images/logo.svg" class="img-fluid float-left" alt="<?=Yii::$app->name?>"  title="<?=Yii::$app->name?>">
                        <span class="d-none d-lg-block">Межрегиональный центр<br>развития профессионального<br>медицинского образования</span>
                    <?php endif; ?>
                </div>
                <div class="col-sm-7 offset-sm-1 col-md-8 offset-md-0">
                    <div class="d-flex justify-content-end">
                        <div class="mr-lg-2 d-none d-lg-flex align-items-center">
                            <?php if($mail = Config::getConfig(2)): ?>
                                <a href="mailto:<?=$mail?>" class="menu-icons email-icon"></a>
                                <a href="mailto:<?=$mail?>" class="d-none d-xl-inline-block"><?=$mail?></a>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center mr-xl-3">
                            <?php if($phone = Config::getConfig(1)): ?>
                                <a href="tel:<?=$phone?>" class="menu-icons phone-icon"></a>
                                <a href="tel:<?=$phone?>" class="d-none d-xl-inline-block"><?=$phone?></a>
                            <?php endif; ?>
                        </div>
                        <div class="text-center pt-3 social d-none d-xl-flex">
                            <?=Config::getConfig(5)?>
                        </div>
                        <div>
                            <nav id="w0" class="navbar navbar-expand navbar-light lg-light pr-xl-0">
                                <ul class="navbar-nav">
                                    <?php if (Yii::$app->user->isGuest) { ?>
                                        <li class="nav-item d-flex">
                                            <a href="<?=Url::to(['/user/auth','formtype'=>'signin'])?>" id="modal-signup-link" class="menu-icons auth-link signup-icon" data-toggle="modal" data-target="#modal"></a>
                                            <span class="d-none d-lg-flex">
                                                <a href="<?=Url::to(['/user/auth','formtype'=>'signup'])?>" class="nav-link signup auth-link" data-target="#modal" data-toggle="modal">Регистрация</a></span>
                                        </li>
                                        <li class="nav-item separate d-none d-lg-flex"></li>
                                        <li class="nav-item d-none d-lg-flex">
                                            <a href="<?=Url::to(['/user/auth','formtype'=>'signin'])?>" id="modal-signin-link" class="nav-link auth-link" data-toggle="modal" data-target="#modal">Войти</a>

                                        </li>
                                    <?php } else { ?>
                                        <li class="nav-item position-relative show mr-2">
                                            <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php if ($img = \common\models\Profile::getAvatarimg()) : ?>
                                                    <img src="<?=$img['img']?>" alt="<?=$img['alt']?>"><?php //if($img['alt']) echo $img['alt']; ?>
                                                <?php else: ?>
                                                    <div class="greycircle">
                                                        <img src="/images/profile/menunoava.svg" class="mx-auto d-block" alt="">
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                            <div class="dropdown-menu">
                                                <?=Html::a('Профиль',['/profile/update'],['class'=>"dropdown-item"])?>
                                                <?=Html::a('Личная информация',['/user/security'],['class'=>"dropdown-item"])?>
                                            </div>
                                        </li>
                                        <li class="show">
                                            <a id="dropdownSubMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="greycircle nav-link" title="">
                                                <img src="/images/bell.svg" class="mx-auto d-block"  alt="">
<!--                                                <span class="badge badge-warning navbar-badge">15</span>-->
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
        <nav id="w1" class="navbar-dark navbar-expand-xl navbar">
            <div class="container">
                <button type="button" class="navbar-toggler menu-icons" data-toggle="collapse" data-target="#w1-collapse" aria-controls="w1-collapse" aria-expanded="false" aria-label="Toggle navigation"></button>

                <div id="w1-collapse" class="collapse navbar-collapse">

                        <?= \common\widgets\menu\Menu::widget([
                            'items' => \frontend\services\MenuArray::getData('top'),
                            'options' => ['id'=>'topmenu', 'class' => 'navbar-nav d-flex justify-content-start justify-content-xl-between nav pl-xs-15 pl-15 pl-xl-0'],
                            'encodeLabels'=>false,
                            'activateParents'=>true,
                            'itemOptions' => ['class' => 'nav-item d-flex'],
//                            'activeCssClass'=>'active',
//                                'linkOptions'=>['class'=>'nav-item'],
//                            'linkTemplate' => '<a href="{url}" data-method="{method}">{label}</a>',
                        ]); ?>

                </div>
            </div>
        </nav>
    </div>

<div class="wrap">
    <?php if($nobreadcrumb === null): ?>
    <div class="container">
        <?php echo $this->render('//layouts/_breadcrumb') ?>

    </div>
    <?php endif; ?>
                <?= $content ?>
</div>

<footer class="footer">
    <div class="container">
        <div class="row d-flex justify-content-between align-items-top">
            <div class="col-sm-12 col-xl-4 pt-1 logo pb-3">
                <div>
                <?php if(Yii::$app->request->url !== Yii::$app->homeUrl): ?>
                    <a href="/"><img src="/images/logo.svg" class="img-fluid float-left" alt="<?=Yii::$app->name?>"  title="<?=Yii::$app->name?>">
                        Межрегиональный центр<br>развития профессионального<br>медицинского образования</a>
                <?php else: ?>
                    <img src="/images/logo.svg" class="img-fluid float-left" alt="<?=Yii::$app->name?>"  title="<?=Yii::$app->name?>">
                    Межрегиональный центр<br>развития профессионального<br>медицинского образования
                <?php endif; ?>
                </div>
                <div class="mt-4 pt-3 social">
                    <?=Config::getConfig(6)?>
                </div>
            </div>
            <div class="col-sm-12 col-xl-5 pt-1 pb-3">
                <h4>Меню</h4>
                <div class="float-left mr-5">
                <ul class="navbar-nav">
                    <li class="nav-item"><?=Html::a('Календарь мероприятий',['/webinar/index'])?></li>
                    <li class="nav-item"><?=Html::a('Вебинары',['/webinar/index'])?></li>
                    <li class="nav-item"><?=Html::a('Лекторы',['/speaker/index'])?></li>
                    <li class="nav-item"><?=Html::a('Статьи',['/article-category/index'])?></li>
                </ul>
                </div>
                <div>
                <ul class="navbar-nav">
                    <li class="nav-item"><?=Html::a('Календарь мероприятий',['/webinar/index'])?></li>
                    <li class="nav-item"><?=Html::a('Вебинары',['/webinar/index'])?></li>
                    <li class="nav-item"><?=Html::a('Лекторы',['/speaker/index'])?></li>
                    <li class="nav-item"><?=Html::a('Статьи',['/article-category/index'])?></li>
                </ul>
                </div>
            </div>
            <div class="col-sm-12 col-xl-3 pt-1 pb-3">
                <h4>Контакты</h4>
                <div>
                    <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.2188 8.86189C19.6502 8.86189 20 8.51839 20 8.09463V3.06905C20 1.37678 18.5981 0 16.875 0H3.125C1.40188 0 0 1.37678 0 3.06905V11.9309C0 13.6232 1.40188 15 3.125 15H16.875C18.5981 15 20 13.6232 20 11.9309C20 11.5072 19.6502 11.1637 19.2188 11.1637C18.7873 11.1637 18.4375 11.5072 18.4375 11.9309C18.4375 12.7771 17.7366 13.4655 16.875 13.4655H3.125C2.26344 13.4655 1.5625 12.7771 1.5625 11.9309V3.23164L8.3498 7.37659C8.85875 7.68737 9.42937 7.84277 10 7.84277C10.5706 7.84277 11.1412 7.68737 11.6502 7.37659L18.4375 3.23164V8.09463C18.4375 8.51839 18.7873 8.86189 19.2188 8.86189ZM10.8251 6.07343C10.3162 6.38421 9.68383 6.38424 9.17492 6.07343L2.21441 1.82271C2.47098 1.64141 2.78551 1.53453 3.125 1.53453H16.875C17.2145 1.53453 17.529 1.64144 17.7856 1.82275L10.8251 6.07343Z" fill="#5C6673"/>
                </svg>
                <a href="mailto:<?=Config::getConfig(4)?>"><?=Config::getConfig(4)?></a>
                </div>
                <div class="mt-2">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.42183 2.14775C9.43368 2.14775 9.44521 2.14768 9.45698 2.14768C11.1705 2.14768 12.7762 2.81016 13.9811 4.01511C15.196 5.23001 15.8605 6.84935 15.8523 8.57479C15.8505 8.96309 16.1638 9.27939 16.5521 9.28126C16.5533 9.28126 16.5544 9.28126 16.5555 9.28126C16.9422 9.28126 17.2567 8.96865 17.2585 8.58147C17.2686 6.47782 16.4577 4.50301 14.9755 3.02071C13.5048 1.54995 11.5464 0.741422 9.4572 0.741422C9.44436 0.741422 9.43143 0.741457 9.41856 0.741492C9.03022 0.743355 8.71694 1.05966 8.71877 1.44796C8.72064 1.83514 9.03507 2.14775 9.42183 2.14775Z" fill="#5C6673"/>
                    <path d="M17.9983 14.5038C17.9732 13.8076 17.6831 13.1578 17.1816 12.6742C16.1997 11.7274 15.377 11.1808 14.5925 10.9541C13.5114 10.6416 12.5103 10.9258 11.6168 11.7984C11.6155 11.7997 11.6141 11.801 11.6128 11.8024L10.6612 12.7468C10.0702 12.4148 8.92131 11.6842 7.66472 10.4275L7.57218 10.3351C6.32385 9.08677 5.58856 7.93132 5.25401 7.33788L6.19757 6.38722C6.1989 6.38588 6.20021 6.38455 6.20154 6.38317C7.07416 5.48971 7.35826 4.48853 7.04586 3.40754C6.81917 2.6231 6.27259 1.80037 5.32569 0.818414C4.84212 0.316908 4.19236 0.0268683 3.49615 0.00176669C2.80009 -0.0232998 2.13096 0.219068 1.61244 0.684539L1.59226 0.702679C1.58287 0.711082 1.57373 0.719765 1.56484 0.72866C0.532647 1.76078 -0.00840903 3.20578 9.88099e-05 4.90738C0.0145129 7.79794 1.60319 11.1037 4.24977 13.7502C4.25198 13.7524 4.25416 13.7546 4.25637 13.7567C4.75391 14.2536 5.3188 14.7452 5.93551 15.2181C6.24366 15.4544 6.68501 15.3961 6.92133 15.0879C7.15762 14.7797 7.09937 14.3384 6.79118 14.1021C6.22039 13.6645 5.6999 13.2115 5.24416 12.7558C5.24198 12.7536 5.2398 12.7514 5.23759 12.7493C2.851 10.36 1.41894 7.42637 1.40632 4.90031C1.39978 3.58983 1.79399 2.49601 2.54647 1.73575L2.55185 1.7309C3.06296 1.27218 3.83675 1.30009 4.31347 1.79446C6.1339 3.68229 6.00206 4.57354 5.19769 5.39838L3.8943 6.71157C3.6899 6.91752 3.63298 7.22788 3.75104 7.49296C3.78412 7.56728 4.58456 9.3361 6.5781 11.3296L6.67063 11.4221C8.66393 13.4154 10.4328 14.2158 10.5071 14.2489C10.7722 14.367 11.0825 14.3101 11.2885 14.1057L12.6014 12.8025C13.4264 11.998 14.3177 11.866 16.2056 13.6865C16.6999 14.1632 16.7279 14.937 16.2692 15.448L16.2642 15.4535C15.5101 16.1999 14.428 16.5937 13.1317 16.5937C13.1211 16.5937 13.1104 16.5937 13.0997 16.5937C12.0636 16.5885 10.8638 16.3045 9.63013 15.7724C9.27358 15.6185 8.85982 15.7829 8.70601 16.1395C8.5522 16.496 8.71659 16.9098 9.07315 17.0636C10.4992 17.6787 11.8515 17.9937 13.0926 17.9999C13.1058 18 13.1189 18 13.1321 18C14.8166 18 16.2472 17.4593 17.2713 16.4352C17.2803 16.4263 17.2889 16.4172 17.2973 16.4078L17.3156 16.3875C17.7809 15.869 18.0234 15.2001 17.9983 14.5038Z" fill="#5C6673"/>
                    <path d="M12.9888 5.01148C12.2345 4.25723 11.5107 4.05709 11.1628 3.96087C10.7884 3.85733 10.4012 4.07685 10.2977 4.45116C10.1942 4.82543 10.4137 5.21275 10.788 5.31625C11.0725 5.39493 11.5023 5.51383 11.9944 6.00584C12.4681 6.4795 12.5939 6.90711 12.6772 7.19008L12.6873 7.2245C12.7778 7.53026 13.0578 7.72826 13.3612 7.72826C13.4273 7.72829 13.4946 7.71887 13.5611 7.69915C13.9335 7.58893 14.146 7.19771 14.0358 6.82537L14.0262 6.7931C13.9178 6.42459 13.7159 5.73862 12.9888 5.01148Z" fill="#5C6673"/>
                </svg>
                <?=Config::getConfig(3)?>
                </div>
            </div>
        </div>
        <div class="row row_copyright">
            <div class="col-12">
                <p class="text-center">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            </div>
        </div>
    </div>
</footer>

<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="modalnotice" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="/images/btn_close.svg" alt="Закрыть"></span>
            </button>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<?php //echo $this->render('@common/widgets/alert/_messages') ?>
<?php
if(Yii::$app->session->hasFlash('emailconfirm')):
$msg = '<div class="alert alert-danger p-5" role="alert">'.Yii::$app->session->getFlash("success").'</div>';
//$js = <<< JS
//$(document).ready(function(){
//  $('#modal').modal('show');
//  // $('#modal .modal-content')
//  //     .load($('#modal-signin-link').data('url'));

//});
//JS;
$this->registerJs(
    "$(document).ready(function(){
            $('#modalnotice').modal('show');
            $('.modal-content').html('".$msg."');
            setTimeout(function() { 
                        $('#modal').modal('hide');
                    }, 5000);
});",
        $position = yii\web\View::POS_READY, $key = null  );
//$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null  );
endif;
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
