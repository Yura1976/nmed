<?php

namespace frontend\models\profile;

use yii\db\ActiveRecord;
use common\models\Profile;
use common\models\Region;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string|null $fio
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property string|null $birthday
 * @property int|null $country_id
 * @property int|null $city_id
 * @property string|null $work_place
 * @property string|null $position_id должность
 * @property string|null $avatar
 * @property int $updated_at
 * @property int $bonus
 *
 * @property Region $country
 * @property Region $city
 * @property User $user
 * @property UserBonus[] $userBonuses
 * @property UserBonus[] $userBonuses0
 */
class ProfileForm1 extends Model
{
    private $_user = false;
    public $fio,
        $firstname,
        $middlename,
        $lastname,
        $user_id,
        $birthday,
        $country_id,
        $country_name,
        $city_name,
        $city_id,
        $work_place,
        $position_id,
        $bonus,
        $avatar,
        $file,
        $agree,
        $updated_at;


    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(Profile $user, $config = [])
    {
        $this->_user = $user;
        $this->user_id = $user->user_id;
        $this->firstname = $user->firstname;
        $this->middlename = $user->middlename;
        $this->lastname = $user->lastname;
        $this->birthday = $user->birthday;
        $this->country_id = $user->country_id;
        $this->city_id = $user->city_id;
        $this->country_name = $user->countryName;
        $this->city_name = $user->cityName;
        $this->work_place = $user->work_place;
        $this->position_id = $user->position_id;
        $this->avatar = $user->avatar;
        $this->bonus = $user->bonus;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'country_id', 'city_id', 'updated_at', 'bonus'], 'integer'],
            [['birthday','agree'], 'safe'],
            [['work_place','position_id'], 'string'],
            [['fio'], 'string', 'max' => 255],
            [['firstname','lastname','middlename'], 'string', 'max' => 100],
            [['country_name','city_name'], 'string', 'max' => 155],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['avatar'], 'string', 'max' => 155],
            ['file','image'],
            [['file'], 'file', 'extensions'=>'jpg, gif, png'],
            [['file'], 'file', 'maxSize'=>'100000'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя',
            'fio' => 'Фамилия, имя, отчество',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'birthday' => 'Дата рождения',
            'country_id' => 'Страна',
            'country_name' => 'Страна',
            'city_id' => 'Город',
            'city_name' => 'Город',
            'work_place' => 'Место работы',
            'position_id' => 'Должность',
            'updated_at' => 'Время последнего изменения',
            'bonus' => 'Бонус',
            'avatar' => 'Аватар',
            'file' => 'Аватар',
        ];
    }

    public function uploadFile()
    {
        if($file = UploadedFile::getInstance($this,'file')){
            $dir = Yii::getAlias('@images').'/profile/';
            if(file_exists($dir.$this->avatar)){
                unlink($dir.$this->avatar);
            }
            if(file_exists($dir.'small/'.$this->avatar)){
                unlink($dir.'small/'.$this->avatar);
            }
            if(file_exists($dir.'medium/'.$this->avatar)){
                unlink($dir.'medium/'.$this->avatar);
            }
            if(file_exists($dir.'big/'.$this->avatar)){
                unlink($dir.'big/'.$this->avatar);
            }
            $this->avatar = strtotime('now').'_'.Yii::$app->getSecurity()->generateRandomString(6).'.'.$file->extension;
            $file->saveAs($dir.$this->avatar);
//            $imag = Yii::$app->image->load($dir.$this->avatar);
//            $imag->background('#fff',0);
//            $imag->resize('50','50', Yii\image\drivers\Image::INVERSE);
//            $imag->crop('50','50');
//            $imag->save($dir.'small/'.$this->avatar, 90);
//            $imag = Yii::$app->image->load($dir.$this->avatar);
//            $imag->background('#fff',0);
//            $imag->resize('200','200', Yii\image\drivers\Image::INVERSE);
//            $imag->crop('50','50');
//            $imag->save($dir.'medium/'.$this->avatar, 90);
//            $imag = Yii::$app->image->load($dir.$this->avatar);
//            $imag->background('#fff',0);
//            $imag->resize('550',null, Yii\image\drivers\Image::INVERSE);
//            $imag->save($dir.'big/'.$this->avatar, 90);
            return $this->avatar;
        } else {
            return false;
        }
//        $this->updated_at = new yii\db\Expression('NOW()');
//        return parent::beforeSave($insert);
    }

    public function deleteAvatar($model)
    {
        $dir = Yii::getAlias('@images') . '/profile/';
        if($model->avatar && file_exists($dir.$model->avatar)){
            if(file_exists($dir.$model->avatar)){
                unlink($dir.$model->avatar);
            }
            if(file_exists($dir.'small/'.$model->avatar)){
                unlink($dir.'small/'.$model->avatar);
            }
            if(file_exists($dir.'medium/'.$model->avatar)){
                unlink($dir.'medium/'.$model->avatar);
            }
            if(file_exists($dir.'big/'.$model->avatar)){
                unlink($dir.'big/'.$model->avatar);
            }
            return true;
        }
    }

    public function getSmallImage()
    {
        $dir = Yii::getAlias('@web').'/images/profile/';
        return $dir.'small/'.$this->avatar;

    }
    public function getMediumImage()
    {
        $dir = Yii::getAlias('@web').'/images/profile/';
        return $dir.'medium/'.$this->avatar;

    }

    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'timestamp' => [
//                'class' => TimestampBehavior::className(),
//                'createdAtAttribute' => false,
//                'attributes' => [
////                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
//                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
//                ],
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
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->middlename = $this->middlename;
            $user->country_id = $this->country_id;
            $user->city_id = $this->city_id;
            $user->work_place = $this->work_place;
            $user->position_id = $this->position_id;
            $user->avatar = $this->avatar;
            $user->bonus = $this->bonus;
//            $user->birthday = $this->birthday;
            $user->birthday = date( 'Y-m-d', strtotime( $this->birthday ) );

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
