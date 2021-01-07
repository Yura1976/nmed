<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $root
 * @property string $place
 * @property string $menu_link
 * @property string|null $params
 * @property int $status
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','parent_id', 'place', 'menu_link'], 'required'],
            [['parent_id', 'root', 'status','pos'], 'integer'],
            [['params'], 'string'],
            [['place'], 'string', 'max' => 25],
            [['menu_link'], 'string', 'max' => 250],
            ['pos','default', 'value' => 1],
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
            'parent_id' => 'Родитель',
            'root' => 'Корень',
            'place' => 'Место',
            'menu_link' => 'Ссылка',
            'params' => 'Параметры',
            'status' => 'Опубликовано',
            'pos' => 'Позиция',
        ];
    }



    public function getMenuArray($parent_id = 0)
    {
        $list = Menu::find()
//            ->where(['parent_id' => $parent_id,'lang'=>Yii::$app->language])
            ->select(['id','concat(name," (",place,")") as name'])
            ->where(['parent_id'=>0])
            ->orderBy('pos DESC')
//            ->asArray()
            ->all();

        $list = ['0' => 'Корень'] + ArrayHelper::map($list, 'id','name');

        return $list;
    }

    public function getMenuListAdmin($place = 'main')
    {
        $menulist = Menu::find()
            ->where([
                'place' => $place,
//                'published' => [1,2],
                'parent_id' => 0
            ])
            ->asArray()
            ->orderBy('pos DESC')
            ->all();
//var_dump($menulist);
        $menu = [];
        $i=0;
        foreach ($menulist as $item) {
            $submenuquery = Menu::find()->where([
                'place' => $place,
                'status' => [1,2],
                'parent_id' => $item['id']
            ])
                ->asArray()
                ->orderBy('pos ASC')
                ->all();
//            var_dump($submenuquery);
            if(isset($submenuquery)){
//                var_dump($submenu);
                $submenu = [];
//                $menu[$item['id']]['items'] = [];
                foreach ($submenuquery as $sub) {
//                    var_dump($sub['params']);
                    if(isset($sub['menu_link'])){
                        if(isset($sub['params'])){
                            $subparams = explode(';',$sub['params']);
                            $subitems = [];
                            foreach ($subparams as $subparam) {
                                $s = explode('=',$subparam);
                                $subitems[$s[0]] = $s[1];
                            }
                            $suburl = Url::to([$sub['menu_link'],$subitems]);
                        }
                        else{
                            $suburl = Url::to($sub['menu_link']);
                        }
                    }
                    else $suburl = '#';
                    $submenu[$sub['id']]['label'] = $sub['name'];
                    $submenu[$sub['id']]['url'] = $suburl;
                    $submenu[$sub['id']]['params'] = $sub['params'];
                    $submenu[$sub['id']]['place'] = $sub['place'];
                }
            }
//            var_dump($submenu);
            if(isset($item['menu_link'])){
                if(isset($item['params'])){
//                    var_dump($item);
                    $url = Url::to($item['menu_link'],[$item['params']]);
//                    if($item['params'] == 'slug' && $item['id'] == 10){
//                        $slug = Author::findOne(['user_id' => Yii::$app->user->getId()])->slug;
//                        $url = Url::to([$item['menu_link'],'slug' => $slug]);
//                    }
//                    else{
//                        $url = Url::to($item['menu_link'],[$item['params']]);
//                    }
                }
                else{
                    $url = Url::to($item['menu_link']);
                }
            }
            else $url = '#';

            $menu[$item['id']]['label'] = $item['name'];
            $menu[$item['id']]['url'] = $url;
            $menu[$item['id']]['params'] = $item['params'];
            $menu[$item['id']]['place'] = $item['place'];
            if(!empty($submenu)) {
                $menu[$item['id']]['items'] = $submenu;
            }
        }
        return $menu;
    }

    public function getMenuList($place = 'main')
    {
        $menulist = Menu::find()
            ->where([
                'place' => $place,
                'parent_id' => 0
            ])
            ->active()
            ->asArray()
            ->orderBy('pos ASC')
            ->all();

        $menu = [];
        $i=0;
        foreach ($menulist as $item) {
            $submenuquery = Menu::find()->where([
                'place' => $place,
                'parent_id' => $item['id']
            ])
                ->active()
                ->asArray()
                ->orderBy('pos ASC')
                ->all();

            if(isset($submenuquery)){
                $submenu = [];
//                $menu[$item['id']]['items'] = [];
                foreach ($submenuquery as $sub) {
//                    var_dump($sub['params']);
                    if(isset($sub['menu_link'])){
                        if(isset($sub['params'])){
                            $subparams = explode(';',$sub['params']);
                            $subitems = [];
                            foreach ($subparams as $subparam) {
                                $s = explode('=',$subparam);
                                $subitems[$s[0]] = $s[1];
                            }
                            $suburl = Url::to([$sub['menu_link'],$subitems]);
                        }
                        else{
                            $suburl = Url::to($sub['menu_link']);
                        }
                    }
                    else $suburl = '#';
                    $submenu[$sub['id']]['label'] = $sub['name'];
                    $submenu[$sub['id']]['url'] = $suburl;
//                    $submenu[$sub['id']]['params'] = $sub['params'];
                    $submenu[$sub['id']]['place'] = $sub['place'];
                }
            }

            if(isset($item['menu_link'])){
                if($item['params']){
//                    echo "<br>Params=";
//                    var_dump($item['params']);
                    $param = explode(';',$item['params']);
//                    echo "<br>param=";
//                    var_dump($param);
                    $params = [];
                    foreach ($param as $k => $v) {
//                        var_dump("k=".$k. " v=".$v);
                        $itemparam = explode('=',$v);
//                        echo "<br>itemparam=";
//                        var_dump($itemparam[1]);
//                        echo "<br>";
                        $params[$itemparam[0]] = $itemparam[1];
                    }
                    print_r($params);
                    $url = Url::to([$item['menu_link'],$params]);
//                    if($item['params'] == 'slug' && in_array($item['id'],[10,47])){
//                        $slug = Author::findOne(['user_id' => Yii::$app->user->getId()])->slug;
//                        $url = Url::to([$item['menu_link'],'slug' => $slug]);
//                    }
//                    else{
//                        $url = Url::to([$item['menu_link'],$item['params']]);
//                    }
                }
                else{
                    $url = Url::to([$item['menu_link']]);
                }
            }
            else $url = '#';

            $menu[$item['id']]['id'] = $item['id'];
            $menu[$item['id']]['label'] = $item['name'];
            $menu[$item['id']]['url'] = $url;
//            $menu[$item['id']]['params'] = $item['params'];
            $menu[$item['id']]['place'] = $item['place'];
            if(!empty($submenu)) {
                $menu[$item['id']]['items'] = $submenu;
            }
        }

        return $menu;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->parent_id) {
                $this->root = $this->parent_id;
                //доработать возможность добавления более 2-х уровней
            }
            if ($insert) {
                Yii::$app->session->setFlash('success', 'Запись добавлена!');
            } else {
                Yii::$app->session->setFlash('success', 'Запись обновлена!');
            }
            return true;
        } else {
            return false;
        }
    }

    public function getPlaceName()
    {
        return ArrayHelper::getValue(self::getMenuPlacesList(), $this->place);
    }

    public static function getMenuPlacesList()
    {
        return [
            'main' => 'Главное меню',
            'left' => 'Слева'
        ];
    }

    public function getParentName()
    {
        $parent = $this->parent;
        if($parent === null || $parent == 0) {
            return 'Корень';
        } else{
            return $this->parent->name;
        }

    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\MenuQuery
     */
    public function getParent()
    {
        return $this->hasOne(Menu::class, ['id' => 'parent_id']);
    }


    /**
     * @return int
     */
    public function getMaxPos()
    {
        $maxPos = self::find()->max('pos');
        if($maxPos) {
            $pos = $maxPos + 10;
        } else {
            $pos = 10;
        }
        return $pos;
    }

            /**
     * {@inheritdoc}
     * @return \common\models\query\MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MenuQuery(get_called_class());
    }
}
