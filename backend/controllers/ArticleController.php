<?php

namespace backend\controllers;

use Yii;
use common\models\Article;
use common\models\ArticleArticleCategory;
use common\models\search\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
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
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->upload_bg_img = UploadedFile::getInstance($model, 'bg_img');
            $model->upload_annonce_img = UploadedFile::getInstance($model, 'annonce_img');
            $model->upload_detail_img = UploadedFile::getInstance($model, 'detail_img');
            if ($bg_img = $model->uploadImage($model->upload_bg_img, $resize = false)) {
                $model->bg_img = $bg_img;
            }
            if ($annonce_img = $model->uploadImage($model->upload_annonce_img)) {
                $model->annonce_img = $annonce_img;
            }
            if ($detail_img = $model->uploadImage($model->upload_detail_img)) {
                $model->detail_img = $detail_img;
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->status = 1;
        $model->pos = $model->getPosition();
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
        $old_bg_img = $model->bg_img;
        $old_annonce_img = $model->annonce_img;
//        $old_detail_img = $model->detail_img;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->upload_bg_img = UploadedFile::getInstance($model, 'bg_img');
            if ($new = $model->uploadImage($model->upload_bg_img, false)) {
                if (!empty($old_bg_img)) {
                    $model::removeImage($old_bg_img);
                }
                $model->bg_img = $new;
            } else {
                $model->bg_img = $old_bg_img;
            }

            $model->upload_annonce_img = UploadedFile::getInstance($model, 'annonce_img');
            if ($new = $model->uploadImage($model->upload_annonce_img, true, 350)) {
                if (!empty($old_annonce_img)) {
                    $model::removeImage($old_annonce_img);
                }
                $model->annonce_img = $new;
            } else {
                $model->annonce_img = $old_annonce_img;
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if(!$model->categoryids){
            $cat = [];
            foreach ($model->articleArticleCategories as $item) {
                $cat[] = $item['category_id'];
            }
            $model->categoryids = $cat;
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
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
