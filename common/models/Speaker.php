<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Exception;
use yii\imagine\Image;

/**
 * This is the model class for table "speaker".
 *
 * @property int $id
 * @property string $firstname
 * @property string|null $lastname
 * @property string $middlename
 * @property string $avatar
 * @property int|null $country_id
 * @property int|null $region_id
 * @property int|null $city_id
 * @property string|null $work_place
 * @property string|null $position
 * @property int|null $education_id
 * @property int|null $academicdegree_id
 * @property string|null $phone
 * @property string|null $email
 * @property int $created_at
 * @property int $updated_at
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int $status
 *
 * @property SpeakerSpecialty[] $speakerSpecialties
 * @property WebinarSpeaker[] $webinarSpeakers
 */
class Speaker extends \yii\db\ActiveRecord
{
    public $specialtyids;
    public $upload_avatar;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'speaker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname'], 'required'],
            [['education_id', 'academicdegree_id', 'created_at', 'updated_at','country_id','region_id','city_id','status','inindex'], 'integer'],
            [['firstname', 'lastname', 'middlename', 'email'], 'string', 'max' => 100],
            [['avatar'], 'file', 'extensions' => 'png, jpg, svg'],
            [['phone'], 'string', 'max' => 20],
            [['work_place','position'], 'string', 'max' => 500],
            [['description'], 'string'],
            ['education_id', 'exist', 'skipOnError' => true, 'targetClass' => Education::className(), 'targetAttribute' => ['education_id' => 'id']],
            ['academicdegree_id', 'exist', 'skipOnError' => true, 'targetClass' => Academicdegree::className(), 'targetAttribute' => ['academicdegree_id' => 'id']],
            [['meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 250],
            [['specialtyids','fio'],'safe'],
            [['slug'], 'string', 'max' => 150],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'description' => 'Описание',
            'avatar' => 'Аватар',
            'country_id' => 'Страна',
            'city_id' => 'Город',
            'position' => 'Должность',
            'education_id' => 'Образование',
            'academicdegree_id' => 'Ученая степень',
            'specialtyids' => 'Специализация',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'work_place' => 'Место работы',
            'created_at' => 'Время добавления',
            'updated_at' => 'Время последнего изменения',
            'slug' => 'Алиас',
            'status' => 'Статус',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'inindex' => 'Отображать на главной'
        ];
    }

    public function getFio()
    {
        $array = [];
        if($this->lastname){
            $array[] = $this->lastname;
        }
        if($this->firstname){
            $array[] = $this->firstname;
        }
        if($this->middlename){
            $array[] = $this->middlename;
        }
        if(is_array($array)) {
            $fio = implode(" ", $array);
        } else {
            $fio = "";
        }
        return $fio;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug',                      //The attribute to be generated
                'attribute' => 'fio',                          //The attribute from which will be generated
                // optional params
                'maxLength' => 64,                              //Maximum length of attribute slug
                'minLength' => 3,                               //Min length of attribute slug
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true
                    //'regexp' => '/([^A-Za-z0-9]|-)+/',
                    //'rulesets' => ['russian'],
                    //@see all options https://github.com/cocur/slugify
                ]
            ]
        ];
    }


    public function getSpeakerList($q)
    {
        $query = new \yii\db\Query();
        $query->select(['id', 'concat(lastname, " ",firstname, " ",middlename) AS text'])
            ->from(Speaker::tableName())
            ->where(['like', 'concat(lastname, " ",firstname, " ",middlename)', $q])
            ->andWhere(['status' => 1]);
        $query->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        return $data;
    }


    public function getSpeakerInfo()
    {
        $info = [];
        if($this->academicdegree_id){
            $info[] = $this->academicdegree->name;
        }
        if($this->position){
            $info[] = $this->position;
        }
        return implode(', ', $info);
    }

    public function getAvatar()
    {
        $thumb_img = Yii::getAlias('@frontend') . '/web/uploads/speakers/thumb/' . $this->avatar;
        $img = Yii::getAlias('@frontend') . '/web/uploads/speakers/' . $this->avatar;
        if (is_file($thumb_img)) {
            $url = substr('/adminpanel','', Yii::getAlias('@web')) . '/uploads/speakers/thumb/' . $this->avatar;
        } elseif (is_file($img)) {
            $url = substr('/adminpanel', '', Yii::getAlias('@web')) . '/uploads/speakers/' . $this->avatar;
        } else{
            $url = substr('/adminpanel', '', Yii::getAlias('@web')) . '/uploads/speakers/noavatar.svg';
        }
        return $url;
    }

    /*
     * Загружает файл аватарки
     */
    public function uploadImage($file, $resize = true, $w=150, $h=150)
    {
        if ($file) {
            $name = md5(uniqid(rand(), true)) . '.' . $file->extension;
            $path = Yii::getAlias('@frontend/web/uploads/speakers/');
            $source =  $path . $name;
            try {
                $file->saveAs($source);

            } catch (\Exception $e) {
//                var_dump($e->getMessage());
            }
            try {
                if ($resize === true) {
                }
                $path = $path.'thumb/';
                $thumb = $path . $name;
                Image::thumbnail($source, $w, $h)->save($thumb, ['quality' => 90]);
            }catch (\Exception $e) {
//                var_dump($e->getMessage());
            }

            return $name;
        }
        return false;
    }

    /**
     * Удаляет старое изображение при загрузке нового
     */
    public static function removeImage($name) {
        if (!empty($name)) {
            $source = Yii::getAlias('@frontend/web/uploads/speakers/' . $name);
            if (is_file($source)) {
                unlink($source);
            }
            $thumb = Yii::getAlias('@frontend/web/uploads/speakers/thumb/' . $name);
            if (is_file($thumb)) {
                unlink($thumb);
            }
        }
    }




    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if(is_array($this->specialtyids)){

            $speaker_id = $this->id;
            Yii::$app->db->createCommand()->delete('speaker_specialty', 'speaker_id = '.$speaker_id)->execute();

            $newids = [];
            foreach ($this->specialtyids as  $k=>$item) {
                if(isset($item) && $item !== '' && !in_array($item,$newids)) {
                    try {
                        Yii::$app->db->createCommand()->insert('speaker_specialty', [
                            'speaker_id' => $speaker_id,
                            'specialty_id' => $item
                        ])->execute();
                    } catch (Exception $e) {
//                        var_dump($e->getMessage());
                    }


                }
            }

        }


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
     * Gets query for [[SpeakerSpecialties]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SpeakerSpecialtyQuery
     */
    public function getSpeakerSpecialties()
    {
        return $this->hasMany(SpeakerSpecialty::className(), ['speaker_id' => 'id']);
    }

    /**
     * Gets query for [[WebinarSpeakers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WebinarSpeakerQuery
     */
    public function getWebinarSpeakers()
    {
        return $this->hasMany(WebinarSpeaker::className(), ['speaker_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SpeakerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SpeakerQuery(get_called_class());
    }
}
