<?php

namespace backend\controllers;

use common\models\Academicdegree;
use common\models\Education;
use common\models\Position;
use common\models\Specialty;
use Yii;
use common\models\Speaker;
use common\models\search\SpeakerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SpeakerController implements the CRUD actions for Speaker model.
 */
class SpeakerController extends Controller
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
     * Lists all Speaker models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpeakerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Speaker model.
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
     * Creates a new Speaker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Speaker();
        $arr = [];


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->upload_avatar = UploadedFile::getInstance($model, 'avatar');
            if ($img = $model->uploadImage($model->upload_avatar)) {
                $model->avatar = $img;
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $arr['education'] = Education::getDropdownlist();
        $arr['academicdegree'] = Academicdegree::getDropdownlist();
        $arr['position'] = Position::getDropdownlist();

        return $this->render('create', [
            'model' => $model,
            'arr' => $arr,
        ]);
    }

    /**
     * Updates an existing Speaker model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $old_avatar = $model->avatar;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->upload_avatar = UploadedFile::getInstance($model, 'avatar');
            if ($new = $model->uploadImage($model->upload_avatar)) {
                if (!empty($old)) {
                    $model::removeImage($old);
                }
                $model->avatar = $new;
            } else {
                $model->avatar = $old_avatar;
            }

            $model->save();
//            return $this->redirect(['view', 'id' => $model->id]);
        }

        $arr['education'] = Education::getDropdownlist();
        $arr['academicdegree'] = Academicdegree::getDropdownlist();
        $arr['position'] = Position::getDropdownlist();
        return $this->render('update', [
            'model' => $model,
            'arr' => $arr
        ]);
    }

    /**
     * Deletes an existing Speaker model.
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


    public function actionSpecialtyList($q = null)
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            if (!is_null($q)) {
                $data = Specialty::getSpecialtyList($q);
                $out['results'] = array_values($data);
            }

        }
        return $out;

    }

    public function actionSpeakerrList($q = null)
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            if (!is_null($q)) {
                $data = Speaker::getAuthorList($q);
                $out['results'] = array_values($data);
            }

        }
        return $out;

    }


    /**
     * Finds the Speaker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Speaker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Speaker::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
