<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "faq_category".
 *
 * @property int $id
 * @property string $name
 *
 * @property Faq[] $faqs
 */
class FaqCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status','pos'], 'integer'],
            ['status', 'default', 'value' => 1],
            [['name'], 'string', 'max' => 350],
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
            'pos' => 'Порядок'
        ];
    }


    public function getMaxPos()
    {
        $maxpos = FaqCategory::find()->max('pos');
        if($maxpos) {
            $this->pos = $maxpos+10;
        } else {
            $this->pos = 10;
        }

    }

    public function getCategoryArray()
    {
        try {
            $cats = FaqCategory::find()->active()->all();

            return ArrayHelper::map($cats,'id','name');

        } catch  (ErrorException $e) {

            return false;

        }
    }

    /**
     * Gets query for [[Faqs]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\FaqQuery
     */
    public function getFaqs()
    {
        return $this->hasMany(Faq::className(), ['category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\FaqCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\FaqCategoryQuery(get_called_class());
    }
}
