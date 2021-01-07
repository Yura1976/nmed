<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "faq".
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property string $slug
 * @property int|null $category_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property FaqCategory $category
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id','question', 'answer'], 'required'],
            [['answer'], 'string'],
            [['category_id','status', 'created_at', 'updated_at','pos'], 'integer'],
            [['question'], 'string', 'max' => 350],
            ['status', 'default', 'value' => 1],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => FaqCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['slug'], 'string', 'max' => 250],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'category_id' => 'Раздел',
            'created_at' => 'Время создания',
            'updated_at' => 'Время последнего изменения',
            'status' => 'Опубликовано',
            'pos' => 'Порядок',
            'slug' => 'Алиас'
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
            ],
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug',                      //The attribute to be generated
                'attribute' => 'question',                          //The attribute from which will be generated
                // optional params
                'maxLength' => 64,                              //Maximum length of attribute slug
                'minLength' => 3,                               //Min length of attribute slug
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true
                    //'regexp' => '/([^A-Za-z0-9]|-)+/',
                    //'rulesets' => ['russian'],
                    //@see all options https://github.com/cocur/slugify
                ]
            ]
        ];
    }


    public function getMaxPos()
    {
        $maxpos = Faq::find()->max('pos');
        if($maxpos) {
            $this->pos = $maxpos+10;
        } else {
            $this->pos = 10;
        }

    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\FaqCategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(FaqCategory::className(), ['id' => 'category_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\FaqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\FaqQuery(get_called_class());
    }
}
