<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $name
 * @property string|null $full_text
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $published
 * @property int|null $category_id
 * @property int $templateid
 * @property int $pos
 *
 * @property Pagecategory $category
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['full_text'], 'string'],
            [['created_at', 'updated_at', 'published', 'category_id', 'templateid', 'pos'], 'integer'],
            [['name'], 'string', 'max' => 300],
            [['headbg'], 'string', 'max' => 75],
            [['meta_title'], 'string', 'max' => 200],
            [['meta_keywords', 'meta_description'], 'string', 'max' => 250],
            [['lang'], 'string', 'max' => 5],
            [['slug'], 'string', 'max' => 75],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pagecategory::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'full_text' => 'Содержание',
            'created_at' => 'Время добавления',
            'updated_at' => 'Время последнего изменения',
            'slug' => 'Алиас',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'published' => 'Опубликовано',
            'category_id' => 'Раздел',
            'templateid' => 'Шаблон',
            'pos' => 'Позиция',
            'headbg' => 'Изображение для фона',
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
                'attribute' => 'name',                          //The attribute from which will be generated
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

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PagecategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Pagecategory::className(), ['id' => 'category_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PageQuery(get_called_class());
    }
}
