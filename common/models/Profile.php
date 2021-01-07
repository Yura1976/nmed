<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string|null $fio
 * @property string|null $birthday
 * @property int|null $country_id
 * @property int|null $city_id
 * @property string|null $work_place
 * @property string|null $position_id должность
 * @property int|null $education_id образование
 * @property int|null $academicdegree_id ученая степень
 * @property string|null $phone
 * @property string|null $email
 * @property int $created_at
 * @property int $updated_at
 * @property int $last_login_at
 * @property int $last_login_ip
 * @property int $bonus
 * @property string|null $slug
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string|null $invitation_code код_приглашения
 * @property string|null $my_invitation_code мой_код_приглашения
 *
 * @property ArticleCategory[] $articleCategories
 * @property ArticleCategory[] $articleCategories0
 * @property Region $country
 * @property Region $city
 * @property Education $education
 * @property Academicdegree $academicdegree
 * @property User $user
 * @property ProfileSpecialty[] $profileSpecialties
 * @property UserBonus[] $userBonuses
 * @property UserBonus[] $userBonuses0
 */
class Profile extends \yii\db\ActiveRecord
{

    public $specialtyids;
    public $subscribingids;
    public $doc_data;
    public $agree;
    public $country_name;
    public $city_name;
    public $fio;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'country_id', 'city_id', 'position_id','education_id', 'academicdegree_id', 'created_at', 'updated_at', 'last_login_at', 'bonus'], 'integer'],
            [['birthday', 'last_login_ip'], 'safe'],
            [['work_place'], 'string'],
            [['firstname','lastname','middlename', 'email'], 'string', 'max' => 100],
            [['phone','watsapp'], 'string', 'max' => 20],
            [['slug', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 250],
            [['invitation_code', 'my_invitation_code'], 'string', 'max' => 12],
            [['user_id'], 'unique'],
//            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['city_id' => 'id']],
            ['region_id','integer'],
            [['education_id'], 'exist', 'skipOnError' => true, 'targetClass' => Education::className(), 'targetAttribute' => ['education_id' => 'id']],
            [['academicdegree_id'], 'exist', 'skipOnError' => true, 'targetClass' => Academicdegree::className(), 'targetAttribute' => ['academicdegree_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['specialtyids','subscribingids','doc_data','agree','fio'],'safe'],
        ];
    }

//    public function fields()
//    {
//        return [
//            'fio' => function () {
//                return $this->firstname . ' ' . $this->lastname . ' ' . $this->secondname;
//            },
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя',
            'fio' => 'Фамилия, имя, отчетство',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'birthday' => 'Дата рождения',
            'country_id' => 'Страна',
            'city_id' => 'Город',
            'work_place' => 'Место работы',
            'position_id' => 'Должность',
            'education_id' => 'Образование',
            'academicdegree_id' => 'Ученая степень',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'watsapp' => 'Watsapp',
            'created_at' => 'Время добавления',
            'updated_at' => 'Время последнего изменения',
            'last_login_at' => 'Время последней авторизации',
            'last_login_ip' => 'IP-адрес последней авторизации',
            'bonus' => 'Бонус',
            'slug' => 'Алиас',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'invitation_code' => 'Код приглашения',
            'my_invitation_code' => 'Мой код приглашения',
            'smallImage' => 'Аватар',
            'avatar' => 'Аватар'
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


    public function addBonus($user_id, $totalbonus)
    {
        $model = Profile::find()
            ->where(['user_id'=>$user_id])
            ->one();
        if($model !== null){
            $bonus = $model->bonus;
            if(is_integer($bonus) && is_integer($totalbonus)){
                $newbonus = $bonus + $totalbonus;
                $model->bonus = $newbonus;
                $model->save();
            }
        }
    }

    public function getAvatarimg($user_id = null)
    {
        if(Yii::$app->user->id){
            if(!$user_id) {
                $user_id = Yii::$app->user->id;
            }
            $model = Profile::find()->where(['user_id' => $user_id])->one();
            if($model !== null) {
                $dir = Yii::getAlias('@images').'/profile/';
                $webdir = str_replace('/adminpanel','',Yii::getAlias('@web')).'/images/profile/';
                if((file_exists($dir.$model->avatar)) && is_file($dir.$model->avatar) || (file_exists($dir.'small/'.$model->avatar) && is_file($dir.'small/'.$model->avatar))){
                    $avatar['img'] = (file_exists($dir.'small/'.$model->avatar) && is_file($dir.'small/'.$model->avatar)) ? $webdir.'small/'.$model->avatar : $webdir.$model->avatar;
                    if($model->fio) {
                        $avatar['alt'] = $model->fio;
                    } else {
                        $avatar['alt'] = '';
                    }
                    return $avatar;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

//    public function getFio()
//    {
//        $model->fio = '';
//        if($this->firstname){
//
//        }
//    }

//    public function getFirstname()
//    {
//        return $this->profile->firstname;
//    }

    public function getSmallImage()
    {
        $dir = Yii::getAlias('@web').'/images/profile/';
        return $dir.'small/'.$this->avatar;

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
//            } else echo "err";
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

    public function getStrCategories($data)
    {
        $cats = [];
        foreach($data->articleCategories as $item){
            $cats[] = $item->name;
        }
        if($cats) {
            $catsstr = implode("; ", $cats);
            return $catsstr;
        } else {
            return false;
        }
    }


    /**
     * @param int $created_by
     */
//    public function setCreatedBy($created_by)
//    {
//        $this->created_by = $created_by;
//    }

    public function getRegionList($regiontype,$parentid,$q)
    {
        $query = new \yii\db\Query();
        $query->select('id, name AS text')
            ->from(Region::tableName())
            ->where(['like', 'name', $q])
            ->andWhere(['status' => 1]);
        if($regiontype){
            $query->andFilterWhere(['region_type' => $regiontype]);
        }
        if($parentid) {
            $query->andFilterWhere(['country_id' => $parentid]);
        }
        $query->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        return $data;
    }

    public function getCountryName()
    {
        return $this->country->name;
    }

    public function getCityName()
    {
        return $this->city->name;
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\RegionQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Region::className(), ['id' => 'country_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\RegionQuery
     */
    public function getCity()
    {
        return $this->hasOne(Region::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Education]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\EducationQuery
     */
    public function getEducation()
    {
        return $this->hasOne(Education::className(), ['id' => 'education_id']);
    }

    /**
     * Gets query for [[Academicdegree]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AcademicdegreeQuery
     */
    public function getAcademicdegree()
    {
        return $this->hasOne(Academicdegree::className(), ['id' => 'academicdegree_id']);
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PositionQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
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
     * Gets query for [[ProfileSpecialties]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProfileSpecialtyQuery
     */
    public function getProfileSpecialties()
    {
        return $this->hasMany(ProfileSpecialty::className(), ['user_id' => 'user_id']);
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
     * Gets query for [[SubscribingType]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SubscribingtypeQuery
     */
    public function getSubscribingType()
    {
        return $this->hasMany(SubscribingType::class, ['user_id' => 'subscribe_type_id_id'])
            ->viaTable(SubscribeUser::tableName(), ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[SubscribeUser]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SubscribeUserQuery
     */
    public function getSubscribeUser()
    {
        return $this->hasMany(SubscribeUser::class, ['user_id' => 'user_id']);
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
