<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="banner">
<!--        <div class="float-left pl-5"><img src="/images/line1.png" alt=""></div>-->
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
    <div class="body-content">
        <div class="container mt-5">
            <div class="d-flex justify-content-between">
                <h2>Вебинары</h2>
                <div><?=Html::a('Все вебинары',['/webinar/index'],['class'=>'btn btn100 btn-outline-blue'])?></div>
            </div>
            <div class="row mt-5 webinar-list">
                <?= ListView::widget([
                    'dataProvider' => $modelWebinar,
                    'options' => [
                        'tag' => 'div',
                        'class' => 'row mt-0 webinar-list',
                        'id' => 'news-list',
                    ],
                    'itemOptions' => [
                        'tag' => 'div',
                        'class' => 'webinar-item col-12 col-lg-6 g',
                    ],
                    'itemView' => '@app/views/webinar/_list',
                    'layout' => "{items}\n{pager}",
                ]);
                ?>
            </div>
            <div class="d-flex justify-content-between mt-5">
                <h2>Лекторы</h2>
                <div><?=Html::a('Все лекторы',['/speaker/index'],['class'=>'btn btn100 btn-outline-blue'])?></div>
            </div>
            <div class="row wrap-slider speakers-slider mt-3">
                <div class="col-sm-11 ml-auto mr-auto slider-inner">
                <?php $j=1; foreach ($modelSpeaker->getModels() as $speaker): ?>
                    <div>
                        <?php if(($ava = $speaker->getAvatar()) !== false): ?>
                            <img src="<?=$ava?>" alt="<?=$speaker->fio?>" class="img-fluid mx-auto d-block slider-ava rounded-circle">
                        <?php endif; ?>

                        <div class="speaker-fio"><?=Html::a($speaker->fio, ['/speaker/view','slug'=>$speaker->slug])?></div>
                        <?php if($speaker->speakerInfo): ?>
                        <div class="speaker-info">
                            <?=$speaker->speakerInfo?>
                        </div>
                        <?php endif; ?>
<!--                        <div class="speaker-rate">-->
<!--                            <div>-->
<!--                                <span class="rate-title">Средняя оценка</span>-->
<!--                                <span class="rate-value">4.8</span>-->
<!--                                <span class="separator"></span>-->
<!--                                <div>-->
<!--                                    <span class="fa fa-star checked"></span>-->
<!--                                    <span class="fa fa-star checked"></span>-->
<!--                                    <span class="fa fa-star checked"></span>-->
<!--                                    <span class="fa fa-star"></span>-->
<!--                                    <span class="fa fa-star"></span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>

                    <?php $j++; endforeach; ?>

                </div>
            </div>

            <div class="d-flex justify-content-between mt-5">
                <h2>Статьи</h2>
                <div><?=Html::a('Все статьи',['/article-category/index'],['class'=>'btn btn100 btn-outline-blue'])?></div>
            </div>
            <div class="wrap-slider articles-slider mt-4">

                <div class="col-sm-11 ml-auto mr-auto slider-inner" id="carousel1">
                <?php  foreach ($modelArticle->getModels() as $article): ?>
<!--<div class="article-item col-sm-12 col-md-6 col-lg-4 g">-->
                    <div class="article card mt-4 mb-4 border-0">
                        <div class="article-img">
                            <?php if ($img = $article->getImg($article->annonce_img)): ?>
                                <img src="<?=$img?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="article-info">
                                <div><span><?php echo ($category = $article->getStrCategories($article)) ? $category : ''?></span><span>&bull;</span><span class="article-data"><?=$article->dataArticle?></span></div>
                            </div>
                            <div class="article-title"><?=$article->name?></div>
                            <!--        <div class="read">--><?//=Html::a('Читать', ['/article','slug'=>$model->slug])?><!--</div>-->
                            <!--        <div class="card-footer">-->
                            <!--            <div class="read">--><?//=Html::a('Читать', ['/article','slug'=>$model->slug])?><!--</div>-->
                            <!--        </div>-->
                        </div>
                        <div class="card-footer border-0">
                            <div class="read"><?=Html::a('Читать', ['/article/view','slug'=>$article->slug])?></div>
                        </div>
                    </div>
<!--</div>-->


<!--                    <div class="slider-item">-->
<!--                        <div class="article-item">-->
<!--                            --><?php //if ($img = $article->getImg($article->annonce_img)): ?>
<!--                                <img src="--><?//=$img?><!--" alt="" class="img-fluid mx-auto d-block article-thumb">-->
<!--                            --><?php //endif; ?>
<!--                        <div>-->
<!--                        <div class="article-info">-->
<!--                           <div><span>Работа в аптеке</span><span>&bull;</span><span class="article-data">20.09.2020</span></div>-->
<!--                        </div>-->
<!--                        <div class="article-title">-->
<!--                            --><?//=$article->name?>
<!--                        </div>-->
<!--                        <div class="read">-->
<!--                            --><?//=Html::a('Читать', ['/article/view','slug'=>$article->slug])?>
<!--                        </div>-->
<!--                        </div>-->
<!--                        </div>-->
<!--                    </div>-->
                <?php endforeach; ?>

  <?php
//                    echo ListView::widget([
//                        'dataProvider' => $modelArticle,
//                        'options' => [
//                            'tag' => 'div',
//                            'class' => 'row align-items-stretch b-height',
//                            'id' => 'news-list',
//                        ],
//                        'itemOptions' => [
//                            'tag' => 'div',
//                            'class' => 'article-item col-4 g',
//                        ],
//                        'itemView' => '@app/views/article/_list.php',
////        'viewParams' => ['category' => $category],
//                        'layout' => "{items}\n{pager}",
//                    ]) ;
                    ?>


<!--                    <div class="slider-item">-->
<!--                        <div class="article-item">-->
<!--                            <img src="/uploads/articles/1.jpg" class="img-fluid mx-auto d-block article-thumb" alt="img1">-->
<!--                            <div>-->
<!--                                <div class="article-info">-->
<!--                                    <div><span>Работа в аптеке</span><span>&bull;</span><span class="article-data">20.09.2020</span></div>-->
<!--                                </div>-->
<!--                                <div class="article-title">-->
<!--                                    Диалог фармацевта с покупателем в аптеке: три конфликтные ситуации-->
<!--                                </div>-->
<!--                                <div class="read">-->
<!--                                    <a href="#">Читать</a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="slider-item">-->
<!--                        <div class="article-item">-->
<!--                            <img src="/uploads/articles/2.jpg" class="img-fluid mx-auto d-block article-thumb" alt="img1">-->
<!--                            <div>-->
<!--                                <div class="article-info">-->
<!--                                    <div><span>Коронавирус</span><span>&bull;</span><span class="article-data">18.09.2020</span></div>-->
<!--                                </div>-->
<!--                                <div class="article-title">-->
<!--                                    Что мы теперь знаем о SARS-CoV-2: происхождение, симптомы и лечение-->
<!--                                </div>-->
<!--                                <div class="read">-->
<!--                                    <a href="#">Читать</a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="slider-item">-->
<!--                        <div class="article-item">-->
<!--                            <img src="/uploads/articles/3.jpg" class="img-fluid mx-auto d-block article-thumb" alt="img1">-->
<!--                            <div>-->
<!--                                <div class="article-info">-->
<!--                                    <div><span>Мнения экспертов</span><span>&bull;</span><span class="article-data">01.09.2020</span></div>-->
<!--                                </div>-->
<!--                                <div class="article-title">-->
<!--                                    Вакцина от коронавируса: испытания и последние новости-->
<!--                                </div>-->
<!--                                <div class="read">-->
<!--                                    <a href="#">Читать</a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="slider-item">-->
<!--                        <div class="article-item">-->
<!--                            <img src="/uploads/articles/1.jpg" class="img-fluid mx-auto d-block article-thumb" alt="img1">-->
<!--                            <div>-->
<!--                                <div class="article-info">-->
<!--                                    <div><span>Мнения экспертов</span><span>&bull;</span><span class="article-data">01.09.2020</span></div>-->
<!--                                </div>-->
<!--                                <div class="article-title">-->
<!--                                    Вакцина от коронавируса: испытания и последние новости-->
<!--                                </div>-->
<!--                                <div class="read">-->
<!--                                    <a href="#">Читать</a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <div class=" articles-slick-arrow slick-arrow"></div>
            </div>
        </div>
    </div>
</div>
