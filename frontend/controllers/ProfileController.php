<?php

namespace frontend\controllers;

use common\models\Academicdegree;
use common\models\Bonus;
use common\models\Education;
use common\models\Position;
use common\models\Specialty;
use frontend\models\profile\ProfileForm1;
use frontend\models\profile\ProfileForm2;
use frontend\models\profile\ProfileForm3;
use frontend\models\profile\ProfileForm4;
use Yii;
use common\models\Profile;
use common\models\Region;
use common\models\search\ProfileSearch;
use yii\db\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    public $layout = '@app/views/layouts/layoutwithsidebar';

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update','view','regionlist','specialty-list','delete-image','upload-file','ajax-profile-update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'crop'=>[
                'class' => 'daimakuai\avatar\CropAction',
                'config'=>[
                    'bigImageWidth' => '600',
                    'bigImageHeight' => '600',
                    'middleImageWidth'=> '200',
                    'middleImageHeight'=> '200',
                    'smallImageWidth' => '50',
                    'smallImageHeight' => '50',

                    'uploadPath' => 'images/profile/avatar',
                ]
            ]
        ];

    }


    public function actionRegionlist($q = null, $parentid = null, $regiontype = null )
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            if (!is_null($q)) {
                $data = Profile::getRegionList($regiontype,$parentid,$q);
                if($regiontype == 3 && count($data) == 0){
                    $data = Profile::getRegionList(2,$parentid,$q);
                }
                $out['results'] = array_values($data);
            }

        }
        return $out;

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


    /**
     * Lists all Profile models.
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $searchModel = new ProfileSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $id = Yii::$app->user->id;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Profile();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->user_id]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    public function actionAjaxProfileUpdate()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $modelArray = [
                'ProfileForm1',
                'ProfileForm2',
                'ProfileForm3',
                'ProfileForm4'
            ];
            $id = Yii::$app->user->id;
            $profilemodel = $this->findModel($id);

            foreach (array_keys($post) as $key){
                if (in_array($key,$modelArray)){
                    $modelName = '\frontend\models\profile\\'.$key;
                    $model = new $modelName($profilemodel);
                    break;
                }
            }

            if ($model !== null && $model->load(Yii::$app->request->post())) {

                $mymodelName = \yii\helpers\StringHelper::basename(get_class($model));

                $user_id = Yii::$app->user->id;

                //получаем все бонусы и имеющиеся бонусы пользователя
                try {
                    $query = Yii::$app->db->createCommand(
                        'SELECT b.id, ub.id as uid, field_name, bonus_id, b.bonus_value, b.name as bonus_name
                            FROM `bonus` b LEFT JOIN `user_bonus` ub
                            ON b.id = ub.bonus_id AND user_id = :user_id 
                            WHERE b.field_name IS NOT NULL',
                        [
                            ':user_id' => Yii::$app->user->id
                        ])
                        ->queryAll();

                    //получаем данные из формы профиля
                    $postData = Yii::$app->request->post($mymodelName);

                    //обновляем таблицу user_bonus
                    if($query && $postData) {
                        $totalbonus = 0;
                        foreach ($query as $kq => $vq) {
                            if (empty($vq['bonus_id']) && $postData[$vq['field_name']]) {
                                try {
                                    Yii::$app->db->createCommand()
                                        ->insert('user_bonus', [
                                            'user_id' => $user_id,
                                            'bonus_id' => $vq['id'],
                                            'bonus_value' => $vq['bonus_value'],
                                            'bonus_details' => $vq['bonus_name']
                                        ])
                                        ->execute();
                                    if(is_integer($vq['bonus_value'])){
                                        $totalbonus += $vq['bonus_value'];
                                    }
                                } catch (Exception $e) {

                                }
                            } elseif (!empty($vq['bonus_id']) && !$postData[$vq['field_name']]) {
                                try {
                                    $query = Yii::$app->db->createCommand(
                                        "SELECT bonus_value 
                                                FROM `user_bonus` 
                                                WHERE id=" . $vq['uid']
                                    )->queryScalar();
                                    if($query){
//                                        var_dump($query);
                                        $totalbonus -= $query;
                                    }
                                } catch (Exception $e) {

                                }
                                Yii::$app->db->createCommand("DELETE FROM `user_bonus` WHERE id=" . $vq['uid'])
                                    ->execute();
                            }
                        }
                        Profile::addBonus($user_id, $totalbonus);
                    }
                    if ($model->SaveProfile()) {
    //                    var_dump($model);
                        return 'Информация успешно сохранена';
                    } else {
    //                    Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
    //                    return \yii\widgets\ActiveForm::validate($model);
                        return "Невозможно сохранить изменения. Пожалуйста повторите позднее или обратитесь к разработчику";
                    }
                } catch (Exception $e) {

                }

            }
        } else {

            throw new HttpException(404 ,'Page not found');
        }
    }


    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
//        if(Yii::$app->user->id) {
            $id = Yii::$app->user->id;

            $model = $this->findModel($id);

            $form1model = new \frontend\models\profile\ProfileForm1($model);
            $form2model = new \frontend\models\profile\ProfileForm2($model);
            $form3model = new \frontend\models\profile\ProfileForm3($model);
            $form4model = new \frontend\models\profile\ProfileForm4($model);

//            $bonus = Bonus::find()->where(['status' => 1])->asArray()->all();

            if ($form1model->load(Yii::$app->request->post()) && $form1model->saveProfile()) {
                Yii::$app->getSession()->setFlash('success', 'Ваш профиль успешно обновлен');
            }
            if ($form2model->load(Yii::$app->request->post()) && $form2model->saveProfile()) {
                Yii::$app->getSession()->setFlash('success', 'Ваш профиль успешно обновлен');
            }
            if ($form3model->load(Yii::$app->request->post()) && $form3model->saveProfile()) {
                Yii::$app->getSession()->setFlash('success', 'Ваш профиль успешно обновлен');
            }
            if ($form4model->load(Yii::$app->request->post()) && $form4model->saveProfile()) {
                Yii::$app->getSession()->setFlash('success', 'Ваш профиль успешно обновлен');
            }
//            var_dump($form4model->subscribingids);
            $arr = [];
            $arr['education'] = Education::getDropdownlist();
            $arr['academicdegree'] = Academicdegree::getDropdownlist();
            $arr['position'] = Position::getDropdownlist();

            if (!$form4model->subscribingids) {
                $subscr = [];
                foreach ($model->subscribeUser as $item) {
                    $subscr[] = $item['subscribe_type_id'];
                }
                $form4model->subscribingids = $subscr;
            }
            if($form1model->avatar && file_exists(Yii::getAlias('@images').'/profile/'.$form1model->avatar)) {
                $form1model->file = Yii::getAlias('@web').'/images/profile/'.$form1model->avatar;
            }

            if($form1model->country_id) {
                $form1model->country_name = Region::findOne($form1model->country_id)->name;
            }
            if($form1model->city_id) {
                $form1model->city_name = Region::findOne($form1model->city_id)->name;
            }
            return $this->render('update', compact(
                'form1model',
                'form2model',
                'form3model',
                'form4model',
                'arr'
            ));
//        }
//
//        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUploadFile()
    {
        if(isset($_POST["image"]))
        {
            $dir = Yii::getAlias('@images') . '/profile/';

            $data = $_POST["image"];
            $image_array_1 = explode(";", $data);

            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $imageName = time() . '.png';

            file_put_contents('images/profile/'.$imageName, $data);

            $imag = Yii::$app->image->load($dir.$imageName);
            $imag->resize('35','35', Yii\image\drivers\Image::INVERSE);
            $imag->save($dir.'small/'.$imageName, 100);

            $user_id = Yii::$app->user->id;
            $model = Profile::find()->where(['user_id' => $user_id])->one();
            if($model !== null) {
                ProfileForm1::deleteAvatar($model);
            }

            $model->avatar = $imageName;
            $model->save();

            return '<img src="/images/profile/'.$imageName.'" class="img-thumbnail">';

        }

    }

    public function actionDeleteImage($id)
    {
        if($id) {
            $query = Profile::find()->where(['user_id' => $id])->one();
            if($query && $filename = $query->avatar) {

                $dir = Yii::getAlias('@images') . '/profile/';
                if (file_exists($dir . $filename)) {
                    unlink($dir . $filename);
                }
                if (file_exists($dir . 'small/' . $filename)) {
                    unlink($dir . 'small/' . $filename);
                }
                if (file_exists($dir . 'big/' . $filename)) {
                    unlink($dir . 'big/' . $filename);
                }

                $success = true;
            } else {
                $success = false;
            }
        } else{
            $success = false;
        }

        return json_encode($success);
    }


    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::find()->where(['user_id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
