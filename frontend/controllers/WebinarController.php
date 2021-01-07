<?php

namespace frontend\controllers;

use common\models\Profile;
use Yii;
use common\models\Webinar;
use common\models\search\WebinarSearch;
use common\models\WebinarOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    public function actionOrder($id)
    {
        if (($modelWebinar = Webinar::findOne($id)) !== null) {
            $profile = Profile::rules();
//print_r($profile);
            $model = new WebinarOrder();

            return $this->renderAjax('_webinarorder', [
                'model' => $model,
                'modelWebinar' => $modelWebinar,
            ]);
        }

        throw new NotFoundHttpException('The requested page does not exist.');

    }

    /**
     * Lists all Webinar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebinarSearch();

        $params = Yii::$app->request->queryParams;
        if(Yii::$app->request->get('from_date')){
            $params["WebinarSearch"]["from_date"] = Yii::$app->request->get('from_date');
        }
        if(Yii::$app->request->get('to_date')){
            $params["WebinarSearch"]["to_date"] = Yii::$app->request->get('to_date');
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Webinar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($slug),
        ]);
    }

    public function actionWebinarinmodal($id)
    {
        if (($model = Webinar::findOne($id)) !== null) {
            return $this->renderPartial('_modalwebinar',[
                'model'=>$model
            ]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Finds the Webinar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Webinar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Webinar::find()->where(['slug'=>$slug])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
