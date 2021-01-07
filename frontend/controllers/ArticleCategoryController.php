<?php

namespace frontend\controllers;

use Yii;
use common\models\ArticleCategory;
use common\models\search\ArticleCategorySearch;
use common\models\search\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleCategoryController implements the CRUD actions for ArticleCategory model.
 */
class ArticleCategoryController extends Controller
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
     * Lists all ArticleCategory models.
     * @return mixed
     */
    public function actionIndex($slug = null)
    {
        if($slug === null) {
            $searchModel = new ArticleCategorySearch();
            $searchModel->isinlist = 1;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $data = [];
            foreach($dataProvider->getModels() as $category) {
//                $data[] = [
//                    'category' => $category,
//                    'articles' => $category->getArticles()->limit(3)->orderBy(['article.created_at' => SORT_DESC])->all()
//                ];
                $data[$category["id"]] = $category->getArticles()->limit(3)->orderBy(['article.created_at' => SORT_DESC])->all();
            }

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'data' => $data
            ]);
        } else{
            $searchModel = new ArticleSearch();
//            var_dump(Yii::$app->request->queryParams);
            $arr = Yii::$app->request->queryParams;
            if(!array_key_exists('category_slug',Yii::$app->request->queryParams) || $rewrite){
                $arr['category_slug'] = $arr['slug'];
                unset($arr['slug']);
            }

            $dataProvider = $searchModel->search($arr);
//            $query = $dataProvider->query->InnerJoinWith('articleCategories');

//            var_dump($query->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);
            $category = ArticleCategory::find()->where(['slug'=>$slug])->one();

            return $this->render(Yii::getAlias('@web/article/index'), [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'category' => $category
            ]);
        }
    }

    /**
     * Displays a single ArticleCategory model.
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
     * Creates a new ArticleCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ArticleCategory model.
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
     * Deletes an existing ArticleCategory model.
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
     * Finds the ArticleCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
