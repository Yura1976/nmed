<?php

namespace backend\controllers;


use common\models\Common;
use Yii;
use common\models\Event;
use common\models\Speaker;
use common\models\search\EventSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
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
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Event();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $old_imagefile = $model->imagefile;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->upload_imagefile = UploadedFile::getInstance($model, 'imagefile');
            if ($new = Common::uploadImage($model->upload_imagefile,$model->upload_imagefile, $resize = true, 540, 406)) {
                if (!empty($old_imagefile)) {
                    Common::removeImage($old_imagefile);
                }
                $model->imagefile = $new;
            } else {
                $model->imagefile = $old_imagefile;
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } //else var_dump($model->getErrors());


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Event model.
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


    public function actionSpeakersList($q = null)
    {

        $speakers = Speaker::find()
            ->select(['id','concat(lastname, " ",firstname, " ",middlename) as value'])
            ->filterWhere(['like', 'concat(lastname, " ",firstname, " ",middlename)', $q])
            ->asArray()
            ->limit(10)
            ->all();

        $out = [];
        foreach ($speakers as $speaker) {
            $c = explode(", ", $speaker['value']);
            $outs[] = $c[1];
            $speaker_name = implode(", ", $outs);
            $out[] = ['id'=>$speaker['id'],'value' => $speaker['value']];
        }

        return Json::encode($out);
    }


    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
