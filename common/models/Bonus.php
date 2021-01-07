<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "bonus".
 *
 * @property int $id
 * @property string $name
 * @property int $bonus_value
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 *
 * @property UserBonus[] $userBonuses
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'bonus_value'], 'required'],
            [['bonus_value', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['field_name'], 'string', 'max' => 30],
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
            'bonus_value' => 'Значение',
            'created_at' => 'Время создания',
            'updated_at' => 'Время последнего изменения',
            'status' => 'Опубликовано',
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

    public function getBonus()
    {

    }

    public function getUserBonus($user_id)
    {

    }

    public function userBonusUpdate($user_id)
    {

    }

    /**
     * Gets query for [[UserBonuses]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserBonusQuery
     */
    public function getUserBonuses()
    {
        return $this->hasMany(UserBonus::className(), ['bonus_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\BonusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BonusQuery(get_called_class());
    }
}
