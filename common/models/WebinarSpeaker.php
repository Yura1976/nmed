<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webinar_speaker".
 *
 * @property int $id
 * @property int $webinar_id
 * @property int $speaker_id
 *
 * @property Speaker $speaker
 * @property Webinar $webinar
 */
class WebinarSpeaker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webinar_speaker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['webinar_id', 'speaker_id'], 'required'],
            [['webinar_id', 'speaker_id'], 'integer'],
            [['speaker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speaker::className(), 'targetAttribute' => ['speaker_id' => 'id']],
            [['webinar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinar::className(), 'targetAttribute' => ['webinar_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'webinar_id' => 'Webinar ID',
            'speaker_id' => 'Speaker ID',
        ];
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
     * Gets query for [[Webinar]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WebinarQuery
     */
    public function getWebinar()
    {
        return $this->hasOne(Webinar::className(), ['id' => 'webinar_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\WebinarSpeakerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WebinarSpeakerQuery(get_called_class());
    }
}
