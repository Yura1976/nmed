<?php

namespace frontend\controllers;

use Yii;
use common\models\Webinar;
//use common\models\search\WebinarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use edofre\fullcalendarscheduler\models\Event;


/**
 * ArticleController implements the CRUD actions for Article model.
 */
class CalendarController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * @param $id
     * @param $start
     * @param $end
     * @return array
     */
    public function actionEvents($start, $end)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $start=Yii::$app->formatter->asTimestamp($start);
        $end=Yii::$app->formatter->asTimestamp($end);
        $times = Webinar::find()
            ->where(['between', 'startsAt', $start,$end])
            ->all();
//echo "<br>times=";
//var_dump($times);
        $events = array();

        foreach ($times AS $time) {

            $Event = new Event();
            $Event->id = $time->id;
            $Event->title = $time->name;
//            $Event->tip = $time->name;
            $Event->allDay = true;
//            echo "<br>id=". $time->id." start=";
            $Event->start = date('Y-m-d',strtotime($time->startsAt));
            $Event->end = date('Y-m-d',strtotime($time->endsAt));
//            $Event->start = Yii::$app->formatter->asDatetime($time->startsAt);
            $Event->url = \yii\helpers\Url::to(['/webinar/view', 'slug'=>$time->slug]);
            $events[] = $Event;
        }
//        var_dump($events);
        return $events;

//        return [
//            new Event(["id" => "1", "resourceId" => "b", "start" => "2020-12-25T02:00:00", "end" => "2020-12-25T07:00:00", "title" => "event 1"]),
//            new Event(["id" => "2", "resourceId" => "c", "start" => "2020-12-26T05:00:00", "end" => "2020-12-26T22:00:00", "title" => "event 2"]),
//            new Event(["id" => "3", "resourceId" => "d", "start" => "2020-12-25", "end" => "2020-12-25", "title" => "event 3"]),
//            new Event(["id" => "4", "resourceId" => "e", "start" => "2020-12-25T03:00:00", "end" => "2020-12-25T08:00:00", "title" => "event 4"]),
//            new Event(["id" => "5", "resourceId" => "f", "start" => "2020-12-24T00:30:00", "end" => "2020-12-24T02:30:00", "title" => "event 5"]),
//        ];
    }

    public function actionJson($start=NULL,$end=NULL,$_=NULL)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $times = Webinar::find()->where(['between', 'startsAt', $start,$end])->all();

        $events = array();

        foreach ($times AS $time) {

            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $time->id;
            $Event->title = $time->name;
            $Event->allDay = true;

            if($time->club_id) { // если от клубов, то класс один, иначе другой
                $Event->className = 'event-club';
            } else {
                $Event->className = 'event-default';
            }

            $Event->start = date('Y-m-d',strtotime($time->date));
            $Event->url = \yii\helpers\Url::to(['/webinar/view', 'slug'=>$time->slug]);
            $events[] = $Event;

        }

        return $events;
    }


    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $searchModel = new WebinarSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
        return $this->render('index');

    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Webinar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Webinar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
