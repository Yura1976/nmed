<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $name Название
 * @property int $access Уровень доступа
 * @property string $password пароль для входа на мероприятие
 * @property int $rule [Обязательно для серии] правило генерации дат повторения событий в серийном мероприятии
 * @property string $description описание мероприятия. Текстовое поле. Отсуствует разметка или верстка
 * @property int|null $additionalFields регистрационное поле. Передается в виде массива полей.   - label — название поля;   -  type — тип поля. Может быть:          - text — текстовое поле;         - radio — поле с заданными значениями; - values — массив вариантов ответа; - placeholder — значение по умолчанию
 * @property int $isEventRegAllowed [Обязательно для серии] правило регистрации на серию. Значения:- true — регистрация осуществляется на всю серию (Event) мероприятий; - false — регистрироваться нужно на каждое отдельное мероприятие
 * @property int $startsAt
 * @property int $endsAt
 * @property int|null $image ID картинки, которая будет фоном вебинара
 * @property string|null $imagefile
 * @property string $type
 * @property string $lang
 * @property string|null $urlAlias замена названия вебинара в ссылке. Заменяет eventID в ссылке на вебинар; 
 * @property string $lectorIds  ведущий на лендинге. Добавляет иконку с фото и данными ведущего. Передается как массив userID сотрудников организации
 * @property string|null $tags
 * @property string|null $duration длительность мероприятия. Меняет значение "Продолжительность" на лендинге, но не определяет фактическое время завершения. Значение данного поля должно подпадать под регулярное выражение
 * @property int|null $ownerId владелец мероприятия. UserID сотрудника организации.  По умолчанию: создатель организации
 * @property int $defaultRemindersEnabled стандартные напоминания. Включает/отключает набор стандартных напоминаний. Значения: - true - включить напоминания за 1 ч и за 15 минут; - false - выключить напоминания за 1 ч и за 15 минут;
 * @property int|null $eventId идентификатор шаблона
 * @property string|null $link
 */
class Event extends \yii\db\ActiveRecord
{

    public $lecture;
    public $lecture_ids;
    public $newspeakers;
    public $nspeakers;
    public $speakersids;
    public $speakerss;
    public $upload_imagefile;
    public $eventcategoryids;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'access'], 'required'],
            [['name', 'description', 'type', 'lang'], 'string'],
            [['access', 'rule', 'additionalFields', 'isEventRegAllowed', 'image', 'ownerId', 'defaultRemindersEnabled', 'eventId', 'created_at','updated_at'], 'integer'],
            [['lectorIds', 'tags'], 'safe'],
            [['password'], 'string', 'max' => 30],
            ['isEventRegAllowed', 'default', 'value' => false],
            ['defaultRemindersEnabled', 'default', 'value' => true],
//            ['isEventRegAllowed', 'required', 'message' => 'Необходимо выбрать одно из значений'],
            [['imagefile'], 'string', 'max' => 150],
            [['urlAlias'], 'string', 'max' => 250],
            [['duration'], 'string', 'max' => 100],
            [['link'], 'string', 'max' => 300],
            [['lecture','speaker_name', 'speakerss', 'speakersids','eventcategoryids', 'startsAt', 'endsAt','lecture_ids','upload_imagefile'],'safe'],
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
            'access' => 'Уровень доступа к мероприятию',
            'password' => 'Пароль',
            'rule' => 'Правило генерации дат повторения событий в серийном мероприятии',
            'description' => 'Описание',
            'additionalFields' => 'Регистрационное поле',
            'isEventRegAllowed' => 'Правило регистрации на серию',
            'startsAt' => 'Дата/время начала мероприятия',
            'endsAt' => 'Дата/время завершения серии мероприятий',
            'image' => 'Фон вебинара. ID файла в файловой системе, который будет использован в качестве фона',
            'imagefile' => 'Файл фона вебинара',
            'type' => 'Тип мероприятия',
            'lang' => 'Язык интерфейса мероприятия',
            'urlAlias' => 'Замена названия вебинара в ссылке. Заменяет eventID в ссылке на вебинар',
            'lectorIds' => 'Ведущий на лендинге. Добавляет иконку с фото и данными ведущего. ',
            'lecture' => 'Ведущие',
            'speakers' => 'Ведущие',
            'tags' => 'Теги мероприятия',
            'duration' => 'Длительность мероприятия',
            'ownerId' => 'Владелец мероприятия',
            'defaultRemindersEnabled' => 'Стандартные напоминания',
            'eventId' => 'Идентификатор шаблона',
            'link' => 'Публичная ссылка на лендинг мероприятия.',
            'created_at' => 'Время добавления',
            'updated_at' => 'Время последнего изменения',
            'eventcategoryids'=>'Разделы мероприятий'
        ];
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if(is_array($this->speakerss)){
            Yii::$app->db->createCommand()
                ->delete(EventSpeaker::tableName(), 'event_id = '.$this->id)
                ->execute();
            $newids = [];
            foreach ($this->speakerss as $item){
                if(isset($item['lecture_id']) && $item['lecture_id'] !== '' && !in_array($item['lecture_id'],$newids)) {
                    try {
                        Yii::$app->db->createCommand()->insert(EventSpeaker::tableName(), [
                            'event_id' => $this->id,
                            'speaker_id' => $item['lecture_id']
                        ])->execute();
                    } catch (Exception $e) {

                    }
                    $newids[] = $item['lecture_id'];
                }
            }


//            $old_speakers = ArrayHelper::map($this->speakers,'id','fio');

//            $oldTags = ArrayHelper::map($this->tags, 'tag', 'id');
//            $tagsToInsert = array_diff($this->newtags, $oldTags );
//            $tagsToDelete = array_diff($oldTags , $this->newtags);


//            foreach ($this->newspeakers as $speaker) {
////                var_dump($speaker);
//                if(isset($old_speakers[$speaker])){
//                    unset($old_speakers[$speaker]);
//                } else{
//                    $this->createNewSpeaker($speaker);
//                }
//            }
//            EventSpeaker::deleteAll(['speaker_id'=>$this->lecture_id,]);

        }
        if (is_array($this->eventcategoryids)) {
            Yii::$app->db->createCommand()
                ->delete(WebinarCategoryEvent::tableName(), 'event_id = '.$this->id)
                ->execute();
            $newids = [];
            foreach ($this->eventcategoryids as $item) {
                if(isset($item) && $item !== '' && !in_array($item,$newids)) {
                    try {
                        Yii::$app->db->createCommand()->insert(WebinarCategoryEvent::tableName(), [
                            'event_id' => $this->id,
                            'category_id' => $item
                        ])->execute();
                    } catch (Exception $e) {

                    }
                    $newids[] = $item;
                }
            }

        }

    }


    public function beforeDelete()
    {
        if(parent::beforeDelete()) {
            EventSpeaker::deleteAll(['event_id'=>$this->id]);
            return true;
        } else {
            return false;
        }
    }


    public function afterFind()
    {

        $this->startsAt = Yii::$app->formatter->asDate($this->startsAt,'dd.m.yyyy H:m:s');
        $this->endsAt = Yii::$app->formatter->asDate($this->endsAt,'dd.m.yyyy H:m:s');
//        $this->newspeakers = ArrayHelper::map($this->speakers,'id','fio');
    }

    /**
     * Gets query for [[WebinarSpeakers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\EventSpeakerQuery
     */
    public function getEventSpeaker()
    {
        return $this->hasMany(EventSpeaker::class, ['event_id' => 'id']);
    }


    /**
     * Gets query for [[WebinarSpeakers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SpeakerQuery
     */
    public function getSpeakers()
    {
        return $this->hasMany(Speaker::class, ['id' => 'speaker_id'])
            ->viaTable(EventSpeaker::tableName(),['event_id'=>'id']);
    }

    /**
     * @return string[]
     */
    public static function getDefaultRemindersEnabledArray()
    {
        $array = [
            1 => 'включить напоминания за 1 ч и за 15 минут',
            0 => 'выключить напоминания за 1 ч и за 15 минут',
        ];
        return $array;
    }

    public function getDefaultRemindersEnabledName()
    {
        return ArrayHelper::getValue(self::getdefaultRemindersEnabledArray(), $this->defaultRemindersEnabled);
    }

    public function getCategories()
    {
//        $query = WebinarCategory::find()->asArray()->all();

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

    public static function getIsEventRegAllowedArray()
    {
        $array = [
            1 => 'регистрация осуществляется на всю серию (Event) мероприятий',
            0 => 'регистрироваться нужно на каждое отдельное мероприятие (EventSession)'
        ];
        return $array;
    }

    public function getIsEventRegAllowedName()
    {
        return ArrayHelper::getValue(self::getIsEventRegAllowedArray(), $this->isEventRegAllowed);
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


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\EventQuery(get_called_class());
    }
}
