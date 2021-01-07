<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webinar_category_event".
 *
 * @property int $id
 * @property int $event_id
 * @property int $category_id
 *
 * @property WebinarCategory $category
 * @property Event $event
 */
class WebinarCategoryEvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webinar_category_event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'category_id'], 'required'],
            [['event_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WebinarCategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(WebinarCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\EventQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\WebinarCategoryEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WebinarCategoryEventQuery(get_called_class());
    }
}
