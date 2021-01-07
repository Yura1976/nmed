<?php

namespace common\models;
use Yii;
use yii\base\ErrorException;
use yii\imagine\Image;

class Common
{

    public function getFile($dir, $file, $thumbfile = null)
    {

        $img = Yii::getAlias('@frontend') . '/web/uploads/' . $dir . $file;

        $thumb_img = Yii::getAlias('@frontend') . '/web/uploads/' . $dir . 'thumb/' . $thumbfile;
        if($thumbfile !== null && file_exists($thumb_img) && is_file($thumb_img)) {
            $url = substr('/adminpanel','', Yii::getAlias('@web')) . '/uploads/' . $dir . 'thumb/' .  $thumbfile;
        } elseif (file_exists($img) && is_file($img)) {
            $url = substr('/adminpanel', '', Yii::getAlias('@web')) . '/uploads/' . $dir . $file;
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
            $path = Yii::getAlias('@frontend/web/uploads/'.$dir);
            if (!is_dir($path)) {
                \yii\helpers\BaseFileHelper::createDirectory($path);
            }
            $source =  $path . $name;
            try {
                $file->saveAs($source);
                if($resize === true && $file->extension != 'svg') {
                    $path = Yii::getAlias('@frontend/web/uploads/'.$dir.'thumb/');
                    if (!is_dir($path)) {
                        \yii\helpers\BaseFileHelper::createDirectory($path);
                    }
                    $thumb = $path . $name;
                    Image::thumbnail($source, $w, $h)->save($thumb, ['quality' => 90]);
                }
                return $name;
            } catch (ErrorException  $e){
//                var_dump($e->getMessage());
                return false;
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

    public function getIsPublished($published)
    {
        $publishedarray = self::getPublishedArray();
        return $publishedarray[$published];
    }

    public function getPublishedArray()
    {
        return [
            '1' => 'Опубликовано',
            '0' => 'Не опубликовано'
        ];
    }

}
?>