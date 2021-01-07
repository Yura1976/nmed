<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article_category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $annot_text
 * @property string|null $detail_text
 * @property string|null $annonce_img
 * @property string|null $detail_img
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $status
 * @property int $isinindex
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 *
 * @property ArticleArticleCategory[] $articleArticleCategories
 * @property Profile $createdBy
 * @property Profile $updatedBy
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['annot_text', 'detail_text', 'annonce_img', 'detail_img'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'isinindex','pos'], 'integer'],
            [['name', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 150],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
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
            'annot_text' => 'Аннотация',
            'detail_text' => 'Описание раздела',
            'annonce_img' => 'Аннонсовое изображение',
            'detail_img' => 'Детальное изображение',
            'created_at' => 'Время добавления',
            'updated_at' => 'Время последнего изменения',
            'created_by' => 'Кто добавил',
            'updated_by' => 'Кто последний раз изменил',
            'status' => 'Опубликовано',
            'isinindex' => 'Отображать на главной',
            'slug' => 'Алиас',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'pos' => 'Позиция',
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_by = Yii::$app->user->id;
            }
            $this->updated_by = Yii::$app->user->id;
            return true;
        } else {
            return false;
        }
    }


    public function getPosition()
    {
        $position = ArticleCategory::find()->max('pos');
        if($position){
            $pos = $position + 10;
        } else $pos = null;
        return $pos;
    }

    public function getCategoryids($model)
    {
        $ids = [];
        $array = self::getCategoryArray();
        foreach ($model as $item) {
            $ids[] = array_search($item['name'],$array);
        }
        return $ids;
    }

    public function getCategoryArray()
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


    /**
     * Gets query for [[ArticleArticleCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ArticleArticleCategoryQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::class, ['id' => 'article_id'])
            ->viaTable('article_article_category',['category_id'=>'id']);

    }

    /**
     * Gets query for [[ArticleArticleCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ArticleArticleCategoryQuery
     */
    public function getArticleArticleCategories()
    {
        return $this->hasMany(ArticleArticleCategory::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProfileQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProfileQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ArticleCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ArticleCategoryQuery(get_called_class());
    }
}
