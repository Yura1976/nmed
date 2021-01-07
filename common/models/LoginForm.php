<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Имя пользователя (e-mail)',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if($user && $user->status == USER::STATUS_WAIT) {

                $link = Url::to(["user/resendlink"]);
//                $error = 'Ваш аккаунт не активирован. Пожалуйста, перейдите по ссылке, отправленной Вам в письме, или запросите отправку {url1} повторно.';
                $error = Yii::t('app', 'ERROR_WRONG_NOT_ACTIVATED',['link' => $link]);
                $this->addError($attribute, $error);
            } elseif (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Не верное имя пользователя или пароль.');
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
