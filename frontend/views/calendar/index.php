<?php

/* @var $this yii\web\View */

use yii\web\JsExpression;
use yii\helpers\Url;

$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <h2>Календарь событий</h2>

    <div class="mt-5 mb-5">

        <div class="row">
            <div class="col-sm-12">
                <?php
                $url = Url::to('/webinar/webinarinmodal');
                echo edofre\fullcalendar\Fullcalendar::widget([
                      'events' => \yii\helpers\Url::to(['calendar/events']),
                      'clientOptions'=>[
                          'eventMouseover' => new JsExpression("
                             function (calEvent, jsEvent) {
                                          console.log(calEvent.id);      
                                          console.log(jsEvent); 
                                var id = calEvent.id;
                                var url = '".Url::to(['/webinar/webinarinmodal'])."';
//                                $('#modal').modal('show');
//                                $('#modal .modal-content')
//                                        .load(url);
//                                return false;          
                               $.ajax({
//                                  url: form.attr('action'),
                                  url: url,
                                  type: 'GET',
                                  data: {'id' : id},
                                  success: function (result) {
                                    $('#modal').modal('show');
                                     $('.modal-content').css('padding',0);
                                      $('.modal-content').html(result);

//                                      setTimeout(function() {
//                                      $('#modal').modal('hide');
//                                   }, 15000);

                                  },
                                })
                                          
                                               
                             }
                          "),
                        ],
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>


<div id="calendar"></div>
<?php
//$this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css",['depends'=> ['frontend\assets\AppAsset']]);
//$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js",['depends' => [\yii\web\JqueryAsset::class]]);
//$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js",['depends' => [\yii\web\JqueryAsset::class]]);
//$url = Url::to(['calendar/events']);
//$this->registerJs("
//$(document).ready(function() {
//   var calendar = $('#calendar').fullCalendar({
//       header: {
//        left:'prev,next today',
//        center:'title',
//        right:'month,agendaWeek'
//       },
//       events: '".$url."'
//   });
//  });");


?>