<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "nozology".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int $pos
 *
 * @property User $createdBy
 */
class Nozology extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nozology';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message'=> 'Наименование обязательно для заполнения'],
            [['status', 'created_by','pos'], 'integer'],
            [['pos'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'Значение не может быть отрицательным.'],
            [['created_at', 'updated_at'], 'safe'],
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
            'status' => 'Опубликовано',
            'created_at' => 'Время добавления',
            'updated_at' => 'Время изменения',
            'created_by' => 'Кто создал',
            'pos' => 'Позиция'
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if(Yii::$app->user->id) {
                    $this->created_by = Yii::$app->user->id;
                }
            }
            return true;
        } else {
            return false;
        }
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
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NozologyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NozologyQuery(get_called_class());
    }
}
