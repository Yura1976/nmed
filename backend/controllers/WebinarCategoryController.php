<?php

namespace backend\controllers;

use common\models\Common;
use Yii;
use common\models\WebinarCategory;
use common\models\search\WebinarCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * WebinarCategoryController implements the CRUD actions for WebinarCategory model.
 */
class WebinarCategoryController extends Controller
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
     * Lists all WebinarCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebinarCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WebinarCategory model.
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
     * Creates a new WebinarCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WebinarCategory();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

//            $model->upload_icon = UploadedFile::getInstance($model, 'icon_img');
//            $model->upload_bg = UploadedFile::getInstance($model, 'bg_img');
//
//            if ($icon_img = Common::uploadImage('webinar/category/',$model->upload_icon, $resize = false)) {
//                $model->icon_img = $icon_img;
//            }
//            if ($bg_img = Common::uploadImage('webinar/category/',$model->upload_bg, $resize = true)) {
//                $model->bg_img = $bg_img;
//            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->status = 1;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WebinarCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_icon_img = $model->icon_img;
        $old_bg_img = $model->bg_img;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

//            $model->upload_icon = UploadedFile::getInstance($model, 'icon_img');
//            $model->upload_bg = UploadedFile::getInstance($model, 'bg_img');
//
//            if ($model->upload_icon !== null && $new_icon_img = Common::uploadImage('webinar/category/',$model->upload_icon, $resize = false)) {
//                if (!empty($old_icon_img)) {
//                    Common::removeImage($old_icon_img);
//                }
//                $model->icon_img = $new_icon_img;
//            } else {
//                $model->icon_img = $old_icon_img;
//            }
//            if ($model->upload_bg !== null && $new_bg_img = Common::uploadImage('webinar/category/',$model->upload_bg, $resize = true, 540, 406)) {
//
//                if (!empty($old_bg_img)) {
//                    $model->removeImage($old_bg_img);
//                }
//                $model->bg_img = $new_bg_img;
//
//            } else {
//                $model->bg_img = $old_bg_img;
//            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WebinarCategory model.
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
     * Finds the WebinarCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WebinarCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebinarCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
