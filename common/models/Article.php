<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\imagine\Image;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $name
 * @property string|null $annot_text
 * @property string|null $detail_text
 * @property string|null $bg_img
 * @property string|null $annonce_img
 * @property string|null $detail_img
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int|null $data_show
 * @property int $isinindex
 * @property int $status
 * @property int $views
 * @property float $rate
 * @property int $comments
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string $slug
 *
 * @property ArticleArticleCategory[] $articleArticleCategories
 */
class Article extends \yii\db\ActiveRecord
{
    public $categoryids,
            $authorids;
    public $upload;
    public $upload_bg_img;
    public $upload_annonce_img;
    public $upload_detail_img;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['annot_text', 'detail_text'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'isinindex', 'status', 'views', 'comments_count','pos'], 'integer'],
            [['rate'], 'number'],
            [['name', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
            [['subtitle'], 'string', 'max' => 300],
            [['annonce_img', 'detail_img', 'bg_img'], 'file', 'extensions' => 'png, jpg, svg'],
            [['slug'], 'string', 'max' => 150],
            [['slug'], 'unique'],
            [['data_show', 'categoryids','authorids'],'safe'],
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
            'subtitle' => 'Заголовок',
            'annot_text' => 'Аннотация',
            'detail_text' => 'Текст статьи',
            'bg_img' => 'Фоновое изображение',
            'annonce_img' => 'Аннонсовое изображение',
            'detail_img' => 'Детальное изображение',
            'created_at' => 'Время добавления',
            'updated_at' => 'Время последнего изменения',
            'created_by' => 'Кто добавил',
            'data_show' => 'Отображаемая дата добавления',
            'isinindex' => 'Отображать на главной',
            'status' => 'Опубликовано',
            'views' => 'Просмотров',
            'rate' => 'Рейтинг',
            'comments_count' => 'Комментариев',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'slug' => 'Алиас',
            'categoryids' => 'Разделы',
            'authorids' => 'Авторы',
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

    public function getImg($img,$is_thumb = true)
    {
        $path = Yii::getAlias('@uploads').'/articles/';
        $dir = Yii::getAlias('@web').'/uploads/articles/';
        if($is_thumb === true) {
            $path .= 'thumb/';
            $dir .= 'thumb/';
        }
        $file = $path . $img;
        if(file_exists($file) && is_file($file)){
            return str_replace('/adminpanel','',$dir . $img);
        } else{
            return false;
        }
    }

    public function getDataArticle()
    {
        if($this->data_show) {
            $data_show = $this->data_show;
        } else{
            $data_show = Yii::$app->formatter->asDate($this->created_at);
        }
        return $data_show;
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_by = Yii::$app->user->id;
            }
            return true;
        } else {
            return false;
        }
    }


    public function afterFind()
    {
        if($this->data_show) {
            $this->data_show = Yii::$app->formatter->asDate($this->data_show);
        } else{
            $this->data_show = Yii::$app->formatter->asDate($this->created_at);
        }
    }

    public function getPosition()
    {
        $position = Article::find()->max('pos');
        if($position){
            $pos = $position + 10;
        } else $pos = null;
        return $pos;
    }

    public function getArticleAuthorList($id)
    {
        $au = Yii::$app->db->createCommand('SELECT author_id FROM `article_author` WHERE article_id=:article_id')
            ->bindParam(':article_id', $this->id)
            ->queryAll();
        $array = [];
        if(is_array($au)){
            foreach ($au as $item) {
                $array[] = $item["author_id"];
            }
        }
        return $array;

    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if(!$insert){
            $connection = Yii::$app->db;
            if(isset($this->id)) {
                $model = $connection->createCommand('DELETE FROM `article_article_category` WHERE article_id=:article_id');
                $model->bindParam(':article_id', $article_id);
                $article_id = $this->id;
                $model->execute();

                $model = $connection->createCommand('DELETE FROM `article_author` WHERE article_id=:article_id');
                $model->bindParam(':article_id', $article_id);
                $article_id = $this->id;
                $model->execute();
            }
        }
        if(!empty($this->categoryids) && isset($this->id)){
            $data_sql = [];
            foreach ($this->categoryids as $categoryid){
                $data_sql[] = [
                    'article_id' => $this->id,
                    'category_id' => $categoryid
                ];
            }
            Yii::$app->db->createCommand()
                ->batchInsert(
                    'article_article_category',[
                        'article_id', 'category_id'
                    ], $data_sql
                )->execute();
        }

        if(!empty($this->authorids) && isset($this->id)){
            $data_sql = [];
            foreach ($this->authorids as $authorid){
                $data_sql[] = [
                    'article_id' => $this->id,
                    'author_id' => $authorid
                ];
            }
            Yii::$app->db->createCommand()
                ->batchInsert(
                    'article_author',[
                        'article_id', 'author_id'
                    ], $data_sql
                )->execute();
        }

        parent::afterSave($insert, $changedAttributes);

    }

    /*
     * Загружает файл изображения
     */
    public function uploadImage($file, $resize = true, $w=350, $h=240)
    {
        if ($file) {
            $name = md5(uniqid(rand(), true)) . '.' . $file->extension;
            $path = Yii::getAlias('@frontend/web/uploads/articles/');
            $source =  $path . $name;
            if ($file->saveAs($source)) {
                if($resize === true) {
                    $path = Yii::getAlias('@frontend/web/uploads/articles/thumb/');
                    $thumb = $path . $name;
                    Image::thumbnail($source, $w, $h)->save($thumb, ['quality' => 90]);
                }
                return $name;
            }
        }
        return false;
    }

    /**
     * Удаляет старое изображение при загрузке нового
     */
    public static function removeImage($name) {
        if (!empty($name)) {
            $source = Yii::getAlias('@frontend/web/uploads/article/' . $name);
            if (is_file($source)) {
                unlink($source);
            }
            $thumb = Yii::getAlias('@frontend/web/uploads/article/thumb/' . $name);
            if (is_file($thumb)) {
                unlink($thumb);
            }
        }
    }

    /**
     * Удаляет изображение при удалении статьи
     */
    public function afterDelete() {
        parent::afterDelete();
        self::removeImage($this->image);
    }


    public function getStrCategories($data)
    {
        $cats = [];
        foreach($data->articleCategories as $item){
            $cats[] = $item->name;
        }
        if($cats) {
            $catsstr = implode("; ", $cats);
            return $catsstr;
        } else {
            return false;
        }
    }


    public function getAuthorArray()
    {
        $authors = $this->getArticleAuthors();
        return $authors;
    }

    /**
     * Gets query for [[ArticleAuthor]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ArticleAuthorQuery
     */
    public function getArticleAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('article_author', ['article_id' => 'id']);
    }

    /**
     * Gets query for [[ArticleArticleCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ArticleArticleCategoryQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::class, ['id' => 'category_id'])
            ->viaTable(ArticleArticleCategory::tableName(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ArticleArticleCategoryQuery
     */
    public function getArticleArticleCategories()
    {
        return $this->hasMany(ArticleArticleCategory::className(), ['article_id' => 'id']);
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
     * {@inheritdoc}
     * @return \common\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ArticleQuery(get_called_class());
    }
}
