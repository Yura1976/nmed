<?php

namespace backend\controllers;

use common\models\Common;
use common\models\Event;
use common\models\Speaker;
use Yii;
use common\models\Webinar;
use common\models\search\WebinarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * WebinarController implements the CRUD actions for Webinar model.
 */
class WebinarController extends Controller
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
     * Lists all Webinar models.
     * @return mixed
     */
    public function actionIndex($eventId = null)
    {
        $searchModel = new WebinarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if($eventId !== null){
            $event = Event::findOne($eventId);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'event' => $event
        ]);
    }

    /**
     * Displays a single Webinar model.
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
     * Creates a new Webinar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($eventIdnkomed = null)
    {

        $model = new Webinar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        }

        if(!empty($eventIdnkomed)){
            $model->eventIdnkomed = $eventIdnkomed;
            $event = Event::findOne($eventIdnkomed);
            if($event !== null){
                $model->name = $event->name;
                $model->access = $event->access;
                $model->lang = $event->lang;
                $model->startsAt = $event->startsAt;
                $model->endsAt = $event->endsAt;
                $model->type = $event->type;
                $model->description = $event->description;
                $model->description = $event->description;
                $model->bgimage = $event->imagefile;
                $model->urlAlias = $event->urlAlias;
                $model->duration = $event->duration;
                if(is_array($event->speakers)) {
                    $model->speakerss = $event->speakers;
                }
            }
        }

//        if(Yii::$app->request)
        return $this->render('create', [
            'model' => $model,
        ]);



    }

    /**
     * Updates an existing Webinar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_bgimage = $model->bgimage;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->upload_imagefile = UploadedFile::getInstance($model, 'bgimage');
            if ($new_bgimage = Common::uploadImage('webinar/',$model->upload_imagefile, $resize = true, 540, 406)) {
                if (!empty($old_bgimage)) {
                    Common::removeImage($old_bgimage);
                }
                $model->bgimage = $new_bgimage;
            } else {
                $model->bgimage = $old_bgimage;
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Webinar model.
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
     * Finds the Webinar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Webinar the loaded model
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
