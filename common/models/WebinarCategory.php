<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\imagine\Image;

/**
 * This is the model class for table "webinar_category".
 *
 * @property int $id
 * @property string $name
 * @property file $bg_img
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 *
 * @property WebinarCategoryWebinar[] $webinarCategoryWebinars
 */
class WebinarCategory extends \yii\db\ActiveRecord
{

    public $upload_bg;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webinar_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['bg_img'], 'file', 'extensions' => 'png, jpg, svg, gif'],
            [['cssclass'], 'string'],
            [['slug'], 'string', 'max' => 150],
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
            'bg_img' => 'Фоновое изображение',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего изменения',
            'status' => 'Статус',
            'slug' => 'Алиас',
            'cssclass' => 'Класс css'
        ];
    }

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

    public function getIconImg($filename)
    {
        echo $thumb_img = Yii::getAlias('@frontend') . '/web/uploads/webinar/category/thumb/' . $filename;
        $img = Yii::getAlias('@frontend') . '/web/uploads/webinar/category/' . $filename;
        if (is_file($thumb_img)) {
            $url = substr('/adminpanel','', Yii::getAlias('@web')) . '/uploads/webinar/category/thumb/' . $filename;
        } elseif (is_file($img)) {
            $url = substr('/adminpanel', '', Yii::getAlias('@web')) . '/uploads/webinar/category/' . $filename;
        } else{
            $url = null;
        }
        return $url;
    }

    /*
     * Загружает файл иконки
     */
    public function uploadImage($dir, $file, $resize = true, $w=200, $h=200)
    {
        if ($file) {
            $name = md5(uniqid(rand(), true)) . '.' . $file->extension;
            $path = Yii::getAlias('@frontend/web/uploads/').$dir;
            $source =  $path . $name;
            if ($file->saveAs($source)) {
                if($resize === true && $file->extension != 'svg') {
                    $path = Yii::getAlias('@frontend/web/'.$dir.'thumb/');
//                    $path = Yii::getAlias('@frontend/web/webinar/category/thumb/');
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
            $source = Yii::getAlias('@frontend/web/uploads/webinar/category/' . $name);
            if (is_file($source)) {
                unlink($source);
            }
            $thumb = Yii::getAlias('@frontend/web/uploads/webinar/category/thumb/' . $name);
            if (is_file($thumb)) {
                unlink($thumb);
            }
        }
    }



    /**
     * Gets query for [[WebinarCategoryWebinars]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WebinarCategoryWebinarQuery
     */
    public function getWebinarCategoryWebinars()
    {
        return $this->hasMany(WebinarCategoryWebinar::className(), ['category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\WebinarCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WebinarCategoryQuery(get_called_class());
    }
}
