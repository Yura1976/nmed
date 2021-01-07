<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
<!--    <a href="--><?//=\yii\helpers\Url::home()?><!--" class="brand-link">-->
<!--        <img src="--><?//=$assetDir?><!--/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"-->
<!--             style="opacity: .8">-->
<!--        <span class="brand-text font-weight-light">AdminLTE 3</span>-->
<!--    </a>-->

    <!-- Sidebar -->
    <div class="sidebar pt-5">
        <!-- Sidebar user panel (optional) -->
<!--        <div class="user-panel mt-3 pb-3 mb-3 d-flex">-->
<!--            <div class="image">-->
<!--                <img src="--><?////=$assetDir?><!--/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
<!--            </div>-->
<!--            <div class="info">-->
<!--                <a href="#" class="d-block">Admin</a>-->
<!--            </div>-->
<!--        </div>-->

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => 'Пользователи',
                        'url' => ['/user/index'],
                        'icon' => 'users',
                    ],
                    [
                        'label' => 'Справочники',
                        'icon' => 'book',
                        'items' => [
                            ['label' => 'Образование', 'url' => ['education/index'], 'iconStyle' => 'far'],
                            ['label' => 'Ученая стeпень', 'url' => ['academicdegree/index'], 'iconStyle' => 'far'],
                            ['label' => 'Специализация', 'url' => ['specialty/index'], 'iconStyle' => 'far'],
                            ['label' => 'Должность', 'url' => ['position/index'], 'iconStyle' => 'far'],
                            ['label' => 'Нозология', 'url' => ['nozology/index'], 'iconStyle' => 'far'],
                            ['label' => 'Регионы', 'url' => ['region/index'], 'iconStyle' => 'far'],
                            ['label' => 'Типы подписок', 'url' => ['subscribing-type/index'], 'iconStyle' => 'far'],
                            ['label' => 'Бонусы', 'url' => ['bonus/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'Статьи',
                        'icon' => 'th-list',
                        'items' => [
                            ['label' => 'Статьи', 'url' => ['article/index'], 'iconStyle' => 'far'],
                            ['label' => 'Разделы статей', 'url' => ['article-category/index'], 'iconStyle' => 'far'],
                            ['label' => 'Авторы', 'url' => ['author/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'Статические страницы',
                        'icon' => 'th-list',
                        'items' => [
                            ['label' => 'Страницы', 'url' => ['page/index'], 'iconStyle' => 'far'],
                            ['label' => 'Разделы', 'url' => ['pagecategory/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'Вебинары',
                        'icon' => 'file-video',
                        'items' => [
                            ['label' => 'Шаблоны', 'url' => ['event/index'], 'iconStyle' => 'far'],
                            ['label' => 'Вебинары', 'url' => ['webinar/index'], 'iconStyle' => 'far'],
                            ['label' => 'Разделы', 'url' => ['webinar-category/index'], 'iconStyle' => 'far'],
                            ['label' => 'Лекторы', 'url' => ['speaker/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'Часто задаваемые вопросы',
                        'icon' => 'question-circle',
                        'items' => [
                            ['label' => 'Разделы', 'url' => ['faq-category/index'], 'iconStyle' => 'far'],
                            ['label' => 'Вопросы', 'url' => ['faq/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'Меню',
                        'icon' => 'bars',
                        'url' => ['menu/index'],
                    ],
                    [
                        'label' => 'Настройки',
                        'icon' => 'cogs',
                        'url' => ['config/index'],
                    ],


//                    [
//                        'label' => 'Starter Pages',
//                        'icon' => 'tachometer-alt',
//                        'badge' => '<span class="right badge badge-info">2</span>',
//                        'items' => [
//                            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
//                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
//                        ]
//                    ],
//                    ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
//                    ['label' => 'Yii2 PROVIDED', 'header' => true],
//                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
//                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
//                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
//                    ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
//                    ['label' => 'Level1'],
//                    [
//                        'label' => 'Level1',
//                        'items' => [
//                            ['label' => 'Level2', 'iconStyle' => 'far'],
//                            [
//                                'label' => 'Level2',
//                                'iconStyle' => 'far',
//                                'items' => [
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
//                                ]
//                            ],
//                            ['label' => 'Level2', 'iconStyle' => 'far']
//                        ]
//                    ],
//                    ['label' => 'Level1'],
//                    ['label' => 'LABELS', 'header' => true],
//                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
//                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
//                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>