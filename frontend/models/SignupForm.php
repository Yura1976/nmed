<?php
namespace frontend\models;

use common\models\Bonus;
use common\models\Profile;
use common\models\SubscribingType;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\Expression;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $repassword;
    public $phone;
    public $issubscribe;
    public $invitation_code;
    public $check;
    public $agree;
    public $firstname,
        $lastname;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname','lastname','email','password','repassword'], 'required'],
            [['email'], 'trim'],
            ['agree','boolean'],
            ['agree', 'compare', 'compareValue' => 1,'message'=>'Необходимо согласиться с условиями обработки персональных данных'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Это имя пользователя уже занято.'],
            ['email', 'string', 'min' => 5, 'max' => 100],
            ['phone', 'string', 'max' => 20],
//            ['phone', 'match', 'pattern' => '/^(\+7)[(](\d{3})[)](\d{3})[-](\d{2})[-](\d{2})/', 'message' => 'Номер телефона должен быть в формате +7(XXX)XXX-XX-XX'],
//            [['phone'], 'udokmeci\yii2PhoneValidator\PhoneValidator'],

            [['password','repassword'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают'],
            ['issubscribe','integer'],
            ['invitation_code', 'string', 'min' => 3, 'max' => 6],
            [['check'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'email' => 'Имя пользователя (E-mail)',
            'phone' => 'Номер телефона',
            'password' => 'Пароль',
            'repassword' => 'Повторить пароль',
            'verifyCode' => 'Код подтверждения',
            'issubscribe' => 'Подписаться на рассылку',
            'invitation_code' => 'Код приглашения (если есть)',
            'agree' => 'Я согласен с условиями обработки персональных данных'
        ];
    }

    public function getInvitationCode()
    {
        $codeLength = rand(4,6);
        $code = Yii::$app->security->generateRandomString($codeLength);

        if(Profile::find()->where(['my_invitation_code'=>$code])->exists() === true) {
            $this->getInvitationCode();
        }

        return $code;
    }



    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if($user->save()) {
            $bonus = Bonus::findOne(1);
            Yii::$app->db->createCommand()->insert('user_bonus', [
                'user_id' => $user->id,
                'bonus_id' => 1,
                'bonus_value' => $bonus->bonus_value,
                'bonus_details' => 'Регистрация на сайте'
            ])->execute();
            $profile = new Profile();
            $profile->user_id = $user->id;
            if(!empty($this->phone)) {
                $profile->phone = $this->phone;
            }
            if(!empty($this->firstname)) {
                echo $profile->firstname = $this->firstname;
            }
            if(!empty($this->lastname)) {
                $profile->lastname = $this->lastname;
            }
            if(!empty($this->invitation_code)) {
                $profile->invitation_code = $this->invitation_code;
            }
            $profile->email = $user->email;
            $profile->watsapp = $user->email;
            if(!empty($this->invitation_code)) {
                $profile->invitation_code = $this->invitation_code;
            }
            if($bonus->bonus_value){
                $profile->bonus = $bonus->bonus_value;
            }
            $profile->my_invitation_code = $this->getInvitationCode();
            $profile->save();

            if($this->issubscribe){
                $subscribingTypes = SubscribingType::find()
                    ->where(['status'=>1])
                    ->all();
                $sendpulse = Yii::$app->sendpulse;
                $emails = [];
                $subscribingQuery = [];
                foreach ($subscribingTypes as $subscribingType) :
                    $subscribingQuery[] = [
                        $user->id,
                        $subscribingType->id,
                        new Expression('NOW()')
                    ];
                    $bookID = $subscribingType->sendpulse;

                    if(isset($bookID)){
                        $emails[] = array(
                           'email' => $user->email,
                           'variables' => array(
                                'Телефон' => (isset($this->phone)) ? $this->phone : '',
                                'Имя' => (isset($this->firstname)) ? $this->firstname : "",
                                'Фамилия' => (isset($this->lastname)) ? $this->lastname : ""
                           )
                        );
                        $sendpulse->addEmails($subscribingType->sendpulse, $emails);
                    }
                endforeach;
                Yii::$app->db->createCommand()
                    ->batchInsert('subscribe_user', [
                        'user_id',
                        'subscribe_type_id',
                        'created_at'
                    ],
                    $subscribingQuery
                )->execute();
            }

            $this->sendEmail($user);
            return true;
        }

        return false;

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app->mailer->compose(['html' => '@app/mail/emailConfirm'], ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Вы зарегистрировались на сайте ' . Yii::$app->name)
            ->send();

    }
}
