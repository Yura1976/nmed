<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webinar_category_webinar".
 *
 * @property int $id
 * @property int $webinar_id
 * @property int $category_id
 *
 * @property WebinarCategory $category
 * @property Webinar $webinar
 */
class WebinarCategoryWebinar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webinar_category_webinar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['webinar_id', 'category_id'], 'required'],
            [['webinar_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
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
     * @return \common\models\query\WebinarCategoryWebinarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WebinarCategoryWebinarQuery(get_called_class());
    }
}
