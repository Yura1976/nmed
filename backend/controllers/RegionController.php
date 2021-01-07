<?php

namespace backend\controllers;

use Yii;
use common\models\Region;
use common\models\search\RegionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegionController implements the CRUD actions for Region model.
 */
class RegionController extends Controller
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
     * Ajax запрос на создание региона из проводника
     * @return array
     */
    public function actionCreateNode() {
        $parent = Yii::$app->request->post('parent');
        $root = Region::findOne($parent);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($root) {
            $region = new Region(['name' => 'New node']);
            if($region->appendTo($root)) {
                $arr = [
                    'status' => 'success',
                    'id' => $region->id
                ];
                return $arr;
            }
        }

        return [
            'status' => 'error'
        ];
    }

    /**
     * Ajax запрос на переименование региона из проводника
     * @return array
     */
    public function actionRenameNode() {
        $data = Yii::$app->request->post();
        $region = Region::findOne($data['id']);
        $region->name = $data['name'];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($region->save()) {
            return ['response' => 'success'];
        }
        return ['response' => 'error'];
    }
    /**
     * Ajax запрос на удаление региона из проводника
     * @return array
     */
    public function actionDeleteNode() {
        $id = Yii::$app->request->post('id');
        $region = Region::findOne($id);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Region::deleteAll(['parent_id' => $region->id]);
        if($region->delete()) {
            $parentRegion = Region::findOne($region->parent_id); //получаем дочерний регион
            if($parentRegion){
                $parentRegionsCount = Region::find()
                    ->where([
                        'parent_id' => $parentRegion->id
                    ])
                    ->count(); //кол-во дочерних записей дочернего региона
                if($parentRegionsCount == 0){
                    $parentRegion->children = 0;
                    $parentRegion->save();
                }
            }

            return ['response' => 'success'];
        }
        return ['response' => 'error'];
    }

    public function actionTree($id = '#')
    {
        $data = Region::getRegionsList($id,true);

        $regions = [];
        foreach ($data as $row) {
            $childrenvalue = ($row['children'] == 1) ? true : false;
            $text = $row['name'];
            array_push($regions, [
                'id' => $row['id'],
//                'parent' => $row['parent'],
                'text' => $text,
                // 'children' => true
                'children' => $childrenvalue,
//                'icon' => false
            ]);
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $regions;
    }

    /**
     * Lists all Region models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $searchModel = new RegionSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
        return $this->render('index');
//        $q = Region::find()->limit(10)->all();
//        var_dump($q);
//        $query = Region::find()->orderBy(['id'=>SORT_DESC]);
//        $dataProvider = new \yii\data\ActiveDataProvider([
//            'query' => $query,
//            'pagination' => false
//        ]);
//foreach($dataProvider->getModels() as $v){
//    var_dump($v->name_ru);
//}
//        return $this->render('index', [
//            'dataProvider' => $dataProvider
//        ]);


    }

    /**
     * Displays a single Region model.
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
     * Creates a new Region model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Region();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Region model.
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
     * Deletes an existing Region model.
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
     * Finds the Region model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Region the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Region::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
