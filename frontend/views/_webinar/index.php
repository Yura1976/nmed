<?php

/* @var $this yii\web\View */

use yii\web\JsExpression;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-sm-12">
                <?= edofre\fullcalendar\Fullcalendar::widget([
                    'events'        => new JsExpression('[
            {
                "id":null,
                "title":"Appointment #776",
                "allDay":false,
                "start":"2020-09-11T14:00:00",
                "end":null,
                "url":null,
                "className":null,
                "editable":false,
                "startEditable":false,
                "durationEditable":false,
                "rendering":null,
                "overlap":true,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
            {
                "id":"56e74da126014",
                "title":"Appointment #928",
                "allDay":false,
                "start":"2020-09-11T16:00:00",
                "end":"2020-09-13T14:00:00",
                "url":"index.html",
                "className":null,
                "editable":true,
                "startEditable":true,
                "durationEditable":true,
                "rendering":null,
                "overlap":true,
                "constraint":null,
                "source":null,
                "description":"description for All Day Event",
            },
            {
                "id":"56e74da126050",
                "title":"Appointment #197",
                "allDay":false,
                "start":"2016-03-17T15:30:00",
                "end":"2016-03-17T19:30:00",
                "url":null,
                "className":null,
                "editable":true,
                "startEditable":true,
                "durationEditable":true,
                "rendering":null,
                "overlap":false,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
            {
                "id":"56e74da126080",
                "title":"Appointment #537",
                "allDay":false,
                "start":"2016-03-16T11:00:00",
                "end":"2016-03-16T11:30:00",
                "url":null,
                "className":null,
                "editable":false,
                "startEditable":false,
                "durationEditable":true,
                "rendering":null,
                "overlap":true,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
            {
                "id":"56e74da1260a7",
                "title":"Appointment #465",
                "allDay":false,
                "start":"2016-03-15T14:00:00",
                "end":"2016-03-15T15:30:00",
                "url":null,
                "className":null,
                "editable":false,
                "startEditable":true,
                "durationEditable":false,
                "rendering":null,
                "overlap":true,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
        ]'),
                ]);
                ?>
            </div>
        </div>
    </div>
</div>