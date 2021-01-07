<?php

namespace frontend\services;

use common\models\Menu;

class MenuArray
{

    static function getData($menuplace = 'top')
    {

        $collection = Menu::find()
            ->where(['menuplace'=>$menuplace])
            ->orderBy('lft')
            ->asArray()
            ->all();


        $menu = [];

        if($collection){
            $nsTree = new NestedSetsTreeMenu();
            $dataMenu = $nsTree->tree($collection); //создаем дерево в виде массива
            $menu = $dataMenu[0]['items']; //убираем корневой элемент
        }

        return $menu;
    }

}