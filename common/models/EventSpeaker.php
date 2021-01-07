<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_speaker".
 *
 * @property int $id
 * @property int $event_id
 * @property int $speaker_id
 *
 * @property Event $event
 * @property Speaker $speaker
 */
class EventSpeaker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_speaker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'speaker_id'], 'required'],
            [['event_id', 'speaker_id'], 'integer'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['speaker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speaker::className(), 'targetAttribute' => ['speaker_id' => 'id']],
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
            'speaker_id' => 'Speaker ID',
        ];
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
     * Gets query for [[Speaker]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SpeakerQuery
     */
    public function getSpeaker()
    {
        return $this->hasOne(Speaker::className(), ['id' => 'speaker_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EventSpeakerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\EventSpeakerQuery(get_called_class());
    }
}
