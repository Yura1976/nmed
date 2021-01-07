<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "subscribe_user".
 *
 * @property int $id
 * @property int $user_id
 * @property int $subscribe_type_id
 * @property int $created_at
 *
 * @property SubscribingType $subscribeType
 * @property User $user
 */
class SubscribeUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribe_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'subscribe_type_id'], 'required'],
            [['user_id', 'subscribe_type_id', 'created_at'], 'integer'],
            [['subscribe_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubscribingType::className(), 'targetAttribute' => ['subscribe_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
     * Gets query for [[SubscribeType]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SubscribingTypeQuery
     */
    public function getSubscribeType()
    {
        return $this->hasOne(SubscribingType::className(), ['id' => 'subscribe_type_id']);
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
     * {@inheritdoc}
     * @return \common\models\query\SubscribeUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SubscribeUserQuery(get_called_class());
    }
}
