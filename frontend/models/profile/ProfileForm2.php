<?php

namespace frontend\models\profile;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use common\models\Profile;
use common\models\Education;
use common\models\Academicdegree;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property int|null $education_id образование
 * @property int|null $academicdegree_id ученая степень
 * @property int $updated_at
 * @property int $bonus
 * @property Region $country
 * @property Region $city
 * @property Education $education
 * @property Academicdegree $academicdegree
 * @property User $user
 * @property ProfileSpecialty[] $profileSpecialties
 * @property UserBonus[] $userBonuses
 * @property UserBonus[] $userBonuses0
 */
class ProfileForm2 extends Model
{

    private $_user = false;
    public $specialtyids,
        $user_id,
        $doc_data,
        $education_id,
        $academicdegree_id,
        $bonus,
        $updated_at;

    /**
     * ProfileForm2 constructor.
     * @param User $user
     * @param array $config
     */
    public function __construct(Profile $user, $config = [])
    {
        $this->_user = $user;
        $this->education_id = $user->education_id;
        $this->academicdegree_id = $user->academicdegree_id;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['user_id'], 'required'],
            [['user_id', 'education_id', 'academicdegree_id', 'updated_at', 'bonus'], 'integer'],
            [['education_id'], 'exist', 'skipOnError' => true, 'targetClass' => Education::className(), 'targetAttribute' => ['education_id' => 'id']],
            [['academicdegree_id'], 'exist', 'skipOnError' => true, 'targetClass' => Academicdegree::className(), 'targetAttribute' => ['academicdegree_id' => 'id']],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['specialtyids','doc_data'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя',
            'education_id' => 'Образование',
            'academicdegree_id' => 'Ученая степень',
            'updated_at' => 'Время последнего изменения',
            'bonus' => 'Бонус',
            'specialtyids' => 'Специализация'
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
        if ($this->validate()) {
            $user = $this->_user;
            $user->education_id = $this->education_id;
            $user->academicdegree_id = $this->academicdegree_id;
            $user->bonus = $this->bonus;
            return $user->save();
        } else {
            return false;
        }
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
