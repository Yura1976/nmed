<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pagecategory".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 *
 * @property Page[] $pages
 */
class Pagecategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pagecategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 300],
            [['slug'], 'string', 'max' => 75],
            [['meta_title'], 'string', 'max' => 200],
            [['meta_keywords', 'meta_description'], 'string', 'max' => 250],
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
            'name' => 'Наименование',
            'description' => 'Описание',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
            'status' => 'Опубликовано',
            'slug' => 'Алиас',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
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

    public function getdropdownListArray()
    {
        $cats = Pagecategory::find()->where(['status'=>1])->orderBy('name DESC')->all();
        return ArrayHelper::map($cats,'id','name');
    }

    /**
     * Gets query for [[Pages]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PagecategoryQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PagecategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PagecategoryQuery(get_called_class());
    }
}
