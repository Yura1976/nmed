<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use frontend\behaviors\DateToTimeBehavior;

/**
 * This is the model class for table "webinar".
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property int $access
 * @property string|null $lang
 * @property string $startsAt
 * @property int $utcStartsAt
 * @property int $createUserId
 * @property int $timezoneId
 * @property string $endsAt
 * @property int $organizationId
 * @property string $type
 * @property string|null $description
 * @property int $image фон вебинара. ID файла в файловой системе, который будет использован в качестве фона.
 * @property string|null $bgimage фон вебинара
 * @property int $eventsessionId идентификатор вебинара. Используется для регистрации на вебинары, работы с записью
 * @property int $urlAlias
 * @property int $duration
 *
 * @property WebinarCategoryWebinar[] $webinarCategoryWebinars
 * @property WebinarSpeaker[] $webinarSpeakers
 */
class Webinar extends \yii\db\ActiveRecord
{

//    public $speakers;
    public $upload_imagefile;
    public $speakerss;
    public $webinarcategoryids;
    public $startsAtFormated;
    public $from_date,
        $to_date,
        $searchworld;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webinar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['name', 'status', 'access'], 'required'],
            [['name', 'access'], 'required'],
            [['eventId','eventIdnkomed','access', 'utcStartsAt', 'createUserId', 'timezoneId', 'organizationId', 'image', 'eventsessionId', 'urlAlias', 'duration'], 'integer'],
            [['type', 'description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['lang'], 'string', 'max' => 5],
            [['startsAt', 'endsAt'], 'string', 'max' => 25],
            [['bgimage'], 'string', 'max' => 150],
            [['cssclass'], 'string'],
            ['startsAtFormated', 'date', 'format' => 'php:d.m.Y H:m'],
            [['speakerss','upload_imagefile','webinarcategoryids'],'safe'],
            [['slug'], 'string', 'max' => 75],
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
            'name' => 'Наименование',
            'status' => 'Статус',
            'access' => 'Уровень доступа к мероприятию',
            'lang' => 'Язык',
            'startsAt' => 'Дата/время начала мероприятия',
            'utcStartsAt' => 'Utc Starts At',
            'createUserId' => 'Create User ID',
            'timezoneId' => 'Timezone ID',
            'endsAt' => 'Дата/время завершения',
            'organizationId' => 'Organization ID',
            'type' => 'Тип мероприятия',
            'description' => 'Описание',
            'image' => 'Фон вебинара. ID файла в файловой системе, который будет использован в качестве фона',
            'bgimage' => 'Файл фона вебинара',
            'eventsessionId' => 'Eventsession ID',
            'urlAlias' => 'Замена названия вебинара в ссылке. Заменяет eventID в ссылке на вебинар',
            'duration' => 'Длительность мероприятия, мин',
            'eventId' => 'Шаблон',
            'eventIdnkomed' => 'Шаблон',
            'speakers' => 'Ведущие вебинара',
            'speakerss' => 'Ведущие вебинара',
            'cssclass' => 'CSS класс фона вебинара',
            'webinarcategoryids' => 'Специализация вебинара',
            'slug' => 'Алиас',
            'searchworld' => 'Поиск'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => DateToTimeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'startsAtFormated',
                    ActiveRecord::EVENT_AFTER_FIND => 'startsAtFormated',
                ],
                'timeAttribute' => 'startsAt'
            ],
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug',                      //The attribute to be generated
                'attribute' => 'name',                          //The attribute from which will be generated
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

    public static function getAccessArray()
    {
        $array = [
            1 => 'свободный доступ',
            3 => 'свободный доступ с паролем',
            4 => 'регистрация',
            6 => 'регистрация с паролем',
            8 => 'регистрация с последующей ручной модерацией участников',
            10 => 'регистрация с последующей ручной модерацией участников и с паролем'
        ];
        return $array;
    }

    public function getAccessName()
    {
        return ArrayHelper::getValue(self::getAccessArray(), $this->access);
    }


    public static function getTypeArray()
    {
        $array = [
            'webinar' => 'Вебинар',
            'meeting' => 'Встреча'
        ];
        return $array;
    }

    public function getTypeName()
    {
        return ArrayHelper::getValue(self::getTypeArray(), $this->type);
    }

    public static function getLangArray()
    {
        $array = [
            'RU' => 'Русский',
            'EN' => 'Английский'
        ];
        return $array;
    }

    public function getLangName()
    {
        return ArrayHelper::getValue(self::getLangArray(), $this->lang);
    }

    public function getCssclass()
    {
        if($this->cssClass) {
            $cssClass = $this->cssClass;
        } elseif($this->webinarCategories){
            $array = [];
            foreach ($this->webinarCategories as $webinarCategory) {
                if($webinarCategory["cssclass"]){
                    $array[] = $webinarCategory["cssclass"];
                }
            }
            if(is_array($array)){
                $cssClass = $array[array_rand($array,1)];
            }
        } else {
            $cssClass = 'default-webinar-category';
        }
        return ' ' . $cssClass;
    }

    public function beforeSave($insert)
    {

        if($this->startsAt) {
            $this->startsAt = strtotime($this->startsAt);
        }
        if($this->endsAt) {
            $this->endsAt = strtotime($this->endsAt);
        }

        parent::beforeSave($insert);

        return true;

    }


    public function getCategoryArray()
    {
        $query = WebinarCategory::find()->active()->asArray()->all();

        if($query){
            $cats = ArrayHelper::map($query,'id','name');
            return $cats;
        } else{
            return false;
        }
    }

    public function afterFind()
    {
        $this->startsAt = Yii::$app->formatter->asDatetime($this->startsAt, 'dd.m.yyyy H:m');
        $this->endsAt = Yii::$app->formatter->asDatetime($this->endsAt, 'dd.m.yyyy H:m');

        $catsarray = WebinarCategoryWebinar::find()
            ->select('category_id')
            ->where(['webinar_id'=>$this->id])
            ->asArray()
            ->all();
        $cats = [];
        foreach ($catsarray as $item) {
            $cats[] = $item['category_id'];
        }
        $this->webinarcategoryids = $cats;
        $this->speakerss = $this->speakers;

        if(!$this->eventIdnkomed && Yii::$app->request->get('eventIdnkomed')){
            $this->eventIdnkomed = Yii::$app->request->get('eventIdnkomed');
        }

    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if(is_array($this->speakerss)){
            Yii::$app->db->createCommand()
                ->delete(WebinarSpeaker::tableName(), 'webinar_id = '.$this->id)
                ->execute();
            $newids = [];
            foreach ($this->speakerss as $item){
                if(isset($item['lecture_id']) && $item['lecture_id'] !== '' && !in_array($item['lecture_id'],$newids)) {
                    try {
                        Yii::$app->db->createCommand()->insert(WebinarSpeaker::tableName(), [
                            'webinar_id' => $this->id,
                            'speaker_id' => $item['lecture_id']
                        ])->execute();
                    } catch (Exception $e) {

                    }
                    $newids[] = $item['lecture_id'];
                }
            }
        }

        if (is_array($this->webinarcategoryids)) {
            Yii::$app->db->createCommand()
                ->delete(WebinarCategoryWebinar::tableName(), 'webinar_id = '.$this->id)
                ->execute();
            $newids = [];
            foreach ($this->webinarcategoryids as $item) {
                if(isset($item) && $item !== '' && !in_array($item,$newids)) {
                    try {
                        Yii::$app->db->createCommand()->insert(WebinarCategoryWebinar::tableName(), [
                            'webinar_id' => $this->id,
                            'category_id' => $item
                        ])->execute();
                    } catch (Exception $e) {

                    }
                    $newids[] = $item;
                }
            }

        }

    }


    public function getEventArray()
    {
        $events = Event::find()
            ->select(['id','concat("(",id, ")"," ",name) as name'])
            ->active()
            ->orderBy(['id'=>SORT_DESC])
            ->all();
        return ArrayHelper::map($events,'id','name');
    }

    public function getCategoryList()
    {
        $cat = [];
        foreach ($this->webinarCategories as $category){
            $cat[] = $category['name'];
        }
        if(is_array($cat)){
            return implode(', ', $cat);
        }
    }

    public function getSpeakerList()
    {
        $s = [];
        foreach ($this->speakers as $speaker){
            $s[] = $speaker->fio;
        }
        if(is_array($s)){
            return implode(', ', $s);
        }
    }

    /**
     * Gets query for [[WebinarSpeakers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WebinarSpeakerQuery
     */
    public function getWebinarSpeaker()
    {
        return $this->hasMany(WebinarSpeaker::class, ['webinar_id' => 'id']);
    }


    /**
     * Gets query for [[WebinarSpeakers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SpeakerQuery
     */
    public function getSpeakers()
    {
        return $this->hasMany(Speaker::class, ['id' => 'speaker_id'])
            ->viaTable(WebinarSpeaker::tableName(),['webinar_id'=>'id']);
    }

    /**
     * Gets query for [[WebinarSpeakers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SpeakerQuery
     */
    public function getWebinarCategories()
    {
        return $this->hasMany(WebinarCategory::class, ['id' => 'category_id'])
            ->viaTable(WebinarCategoryWebinar::tableName(),['webinar_id'=>'id']);
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\EventQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'eventId']);
    }

    /**
     * Gets query for [[WebinarCategoryWebinars]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WebinarCategoryWebinarQuery
     */
    public function getWebinarCategoryWebinars()
    {
        return $this->hasMany(WebinarCategoryWebinar::class, ['webinar_id' => 'id']);
    }

    /**
     * Gets query for [[WebinarSpeakers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WebinarSpeakerQuery
     */
    public function getWebinarSpeakers()
    {
        return $this->hasMany(WebinarSpeaker::class, ['webinar_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\WebinarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WebinarQuery(get_called_class());
    }
}
