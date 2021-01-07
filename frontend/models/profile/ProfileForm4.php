<?php

namespace frontend\models\profile;

use common\models\Profile;
use common\models\SubscribeUser;
use common\models\SubscribingType;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property int $updated_at

 * @property User $user
 */
class ProfileForm4 extends Model
{

    public $subscribingids,
        $user_id,
        $updated_at,
        $bonus;

    private $_user = false;

    /**
     * ProfileForm constructor.
     * @param User $user
     * @param array $config
     */
    public function __construct(Profile $user, $config = [])
    {
        $this->_user = $user;
        $this->user_id = $user->user_id;
        $this->subscribingids = $user->subscribingids;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['user_id'], 'required'],
            [['user_id', 'updated_at', 'bonus'], 'integer'],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['subscribingids'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя',
            'updated_at' => 'Время последнего изменения',
            'bonus' => 'Бонус',
            'subscribingids' => 'Рассылки'
        ];
    }


    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'timestamp' => [
//                'class' => TimestampBehavior::className(),
//            ]
//        ];
//    }

    /**
     * @return boolean
     */
    public function SaveProfile()
    {

            $user = $this->_user;
            $user->bonus = $this->bonus;


            //sendpulse update
            $sendpulse = Yii::$app->sendpulse;

            $addressbooks = SubscribingType::find()
                ->where(['status'=>1])
                ->asArray()
                ->all();

            $emails[] = array(
                'email' => $user->email,
                'variables' => array(
                    'phone' => (isset($user->phone)) ? $user->phone : '',
                    'Фамилия' => (isset($user->lastname)) ? $user->lastname : '',
                    'Имя' => (isset($user->firstname)) ? $user->firstname : '',
                    'Отчество' => (isset($user->middlename)) ? $user->middlename : '',
                )
            );


            foreach ($addressbooks as $addressbook) {
                if (!empty($addressbook['sendpulse'])) {
                    $bookID = $addressbook['sendpulse'];
                    foreach ($emails as $email) {
                        $isemail = $sendpulse->getEmailInfo($bookID, $email["email"]);

                        if($isemail->is_error === null){
//                            if($isemail->status_explain != 'Unsubscribed'){
//
//                            } else{
//
//                            }
                            if(is_array($this->subscribingids) === false || in_array($addressbook['id'], $this->subscribingids) === false){
                                $emailtoremove = [ $user->email ];
                                $sendpulse->removeEmails($bookID, $emailtoremove);
                            } else {

                            }
                        } else{
                            if(is_array($this->subscribingids) && in_array($addressbook['id'], $this->subscribingids) === true){
                                $emailtoadd[] = $email;
                                $sendpulse->addEmails($bookID, $emailtoadd);
                            } else {

                            }
                        }
                    }
                }
            }

            $connection = Yii::$app->db;
            if(isset($this->user_id)) {
                $user_id = $this->user_id;
                $model = $connection->createCommand('DELETE FROM '.SubscribeUser::tableName().' WHERE user_id=:user_id');
                $model->bindParam(':user_id', $user_id);
                $user_id = $this->user_id;
                $model->execute();
            }
            if(!empty($this->subscribingids) && isset($this->user_id)){
                $data_sql = [];

                foreach ($this->subscribingids as $subscribingid) {
                    $data_sql[] = [
                        'user_id' => $this->user_id,
                        'subscribe_type_id' => $subscribingid,
                        'created_at' => time()
                    ];
                }

                $connection->createCommand()
                    ->batchInsert(
                        SubscribeUser::tableName(),[
                        'user_id', 'subscribe_type_id','created_at'
                    ], $data_sql
                    )->execute();

            }
            return $user->save();

    }

    /**
     * @inheritdoc
     */
//    public function afterSave($insert, $changedAttributes)
//    {
//        if(!$insert){
//            $connection = Yii::$app->db;
//            if(isset($this->user_id)) {
//                $model = $connection->createCommand('DELETE FROM '.SubscribeUser::tableName().' WHERE user_id=:user_id');
//                $model->bindParam(':user_id', $user_id);
//                $user_id = $this->user_id;
//                $model->execute();
//            }
//        }
//        if(!empty($this->subscribingids) && isset($this->user_id)){
//            $data_sql = [];
//            foreach ($this->subscribingids as $subscribingid){
//                $data_sql[] = [
//                    'user_id' => $this->user_id,
//                    'subscribe_type_id' => $subscribingid
//                ];
//            }
//            Yii::$app->db->createCommand()
//                ->batchInsert(
//                    SubscribeUser::tableName(),[
//                    'user_id', 'subscribe_type_id'
//                ], $data_sql
//                )->execute();
//        }
//        parent::afterSave($insert, $changedAttributes);
//
//    }





    /**
     * {@inheritdoc}
     * @return \common\models\query\ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProfileQuery(get_called_class());
    }
}
