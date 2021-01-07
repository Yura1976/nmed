<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subscribing_type".
 *
 * @property int $id
 * @property string $name
 * @property string|null $iconStyle
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $pos
 * @property string $sendpulse
 */
class SubscribingType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribing_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_at', 'updated_at', 'pos'], 'integer'],
            [['name', 'iconStyle'], 'string', 'max' => 255],
            ['sendpulse','safe']
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
            'iconStyle' => 'Иконка',
            'status' => 'Опубликовано',
            'created_at' => 'Время создания',
            'updated_at' => 'Время изменения',
            'pos' => 'Позиция',
            'sendpulse' => 'Адресная книга'
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

    public function getSendpulseArray()
    {
        $sendpulse = Yii::$app->sendpulse;
        $addressBooks = $sendpulse->listAddressBooks();
        $items = ArrayHelper::map($addressBooks,'id','name');
        return $items;
    }

    public function getSubscribingArray()
    {
        $query = (new Query())
            ->select(['id','name'])
            ->from(self::tableName())
            ->where(['status' => 1])
            ->orderBy('name')
            ->createCommand()
            ->queryAll();

        $items = ArrayHelper::map($query,'id','name');

        return $items;
    }


    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            Yii::$app->session->setFlash('success', 'Запись добавлена');
        } else {
            Yii::$app->session->setFlash('success', 'Запись обновлена');
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return int
     */
    public function getMaxPos()
    {
        $maxPos = self::find()->max('pos');
        if($maxPos) {
            $pos = $maxPos + 10;
        } else {
            $pos = 10;
        }
        return $pos;
    }


    /**
     * {@inheritdoc}
     * @return \common\models\query\SubscribingTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SubscribingTypeQuery(get_called_class());
    }
}
