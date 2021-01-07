<?php

namespace backend\controllers;

use Yii;
use common\models\Menu;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'nodeMove' => [
                'class' => 'klisl\nestable\NodeMoveAction',
                'modelName' => Menu::class,
            ],
        ];
    }

    public function actionTest()
    {
        $countries = new Menu(['name' => 'Menu']);
        $countries->makeRoot();
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        //объект ActiveQuery содержащий данные для дерева. depth = 0 - корень.
        $query = Menu::find()->where(['depth' => '0']);

        return $this->render('index', [
            'query' => $query,
        ]);
    }

    public function actionRoot()
    {
        $countries = new Menu(['name' => 'Root']);
        $countries->makeRoot();
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var  $model Menu|NestedSetsBehavior */
        $model = new Menu ();

        //Поиск корневого элемента
        $root = $model->find()->where(['depth' => '0'])->one();

        if ($model->load(Yii::$app->request->post())) {
            //Если нет корневого элемента (пустая таблица)
            if (!$root) {
                /** @var  $rootModel Menu|NestedSetsBehavior */
                $rootModel = new Menu(['name' => 'root', 'url' => '/']);
                $rootModel->makeRoot(); //делаем корневой
                $model->appendTo($rootModel);
            } else {
                $model->appendTo($root); //вставляем в конец корневого элемента
            }

            if ($model->save()){
                return $this->redirect('index');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'root' => $root
        ]);
    }

    /**
     * Updates an existing Menu model.
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
     * Deletes an existing Menu model.
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
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
