<?php

namespace frontend\models\profile;

use common\models\Profile;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string|null $phone
 * @property string|null $watsapp
 * @property string|null $email
 * @property int $updated_at
 * @property int $bonus

 * @property User $user
 * @property UserBonus[] $userBonuses
 * @property UserBonus[] $userBonuses0
 */
class ProfileForm3 extends Model
{
    private $_user = false;
    public $user_id;
    public $email;
    public $phone;
    public $watsapp;
    public $bonus;
    public $updated_at;

    /**
     * ProfileForm constructor.
     * @param User $user
     * @param array $config
     */
    public function __construct(Profile $user, $config = [])
    {
        $this->_user = $user;
        $this->user_id = $user->user_id;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->bonus = $user->bonus;

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['user_id'], 'required'],
            [['user_id', 'bonus','updated_at'], 'integer'],
            [['phone','watsapp'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 255],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя',
            'phone' => 'Телефон',
            'watsapp' => 'Watsapp',
            'email' => 'E-mail',
            'updated_at' => 'Время последнего изменения',
            'bonus' => 'Бонус',
        ];
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }


    /**
     * @return boolean
     */
    public function SaveProfile()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->phone = $this->phone;
            $user->watsapp = $this->watsapp;
            $user->email = $this->email;
            $user->bonus = $this->bonus;
            return $user->save();
        } else {
            return false;
        }
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * Gets query for [[UserBonuses]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserBonusQuery
     */
    public function getUserBonuses()
    {
        return $this->hasMany(UserBonus::className(), ['created_by' => 'user_id']);
    }


    /**
     * {@inheritdoc}
     * @return \common\models\query\ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProfileQuery(get_called_class());
    }
}
