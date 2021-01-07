<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "specialty".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int $pos
 */
class Specialty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specialty';
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



    public function getSpecialtyList($q)
    {
        $query = new \yii\db\Query();
        $query->select('id, name AS text')
            ->from(Specialty::tableName())
            ->where(['like', 'name', $q])
            ->andWhere(['status' => 1]);
        $query->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        return $data;
    }


    public function getSpecialtyArray()
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
     * @return \common\models\query\SpecialtyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SpecialtyQuery(get_called_class());
    }
}
