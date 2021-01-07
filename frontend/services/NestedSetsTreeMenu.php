<?php


namespace frontend\services;

use common\components\nestedSets\NestedSetsTree;
use Yii;


class NestedSetsTreeMenu extends NestedSetsTree
{

    /**
     * @var string
     */
    public $childrenOutAttribute = 'items'; //children

    /**
     * @var string
     */
    public $labelOutAttribute = 'label'; //title


    /**
     * Добавляет в массив дополнительные элементы
     * @param $node
     * @return array
     */
    protected function addItem($node)
    {
        $node = $this->establishMethod($node);
        $node = $this->renameTitle($node); //переименование элемента массива
        $node = $this->visible($node); //видимость элементов меню
        $node = $this->makeActive($node); //выделение активного пункта меню

        return $node;
    }


    /**
     * Переименовываем элемент "name" в "label" (создаем label, удаляем name)
     * требуется для yii\widgets\Menu
     * @param $node
     * @return array
     */
    protected function renameTitle($node)
    {
        $newNode = [
            $this->labelOutAttribute => $node[$this->labelAttribute],
        ];
        unset($node[$this->labelAttribute]);

        return array_merge($node, $newNode);
    }


    /**
     * Видимость пункта меню (visible = false - скрыть элемент)
     * @param $node
     * @return array
     */
    protected function visible($node)
    {
        $newNode = [];

        //Гость
        if (Yii::$app->user->isGuest) {

            //Действие logout по-умолчанию проверяется на метод POST.
            //При использовании подкорректировать VerbFilter в контроллере (удалить это действие или добавить GET).
            if ($node['url'] === '/logout') {
                $newNode = [
                    'visible' => false,
                ];
            }

            //Авторизованный пользователь
        } else {
            if ($node['url'] === '/login' || $node['url'] === '/signup') {
                $newNode = [
                    'visible' => false,
                ];
            }
        }

        return array_merge($node, $newNode);
    }


    /**
     * Добавляет элемент "active" в массив с url соответствующим текущему запросу
     * для назначения отдельного класса активному пункту меню
     *
     * @param $node
     * @return array
     */
    private function makeActive($node)
    {
        //URL без хоста, слэша спереди и параметров запроса
        $path = Yii::$app->request->getPathInfo();

        if (('/' . $path === $node['url'] && !isset($node['params'])) || ('/' . $path === $node['url'] && Yii::$app->request->queryString === $node['params'])) {
            $newNode = [
                'active' => true,
            ];
            return array_merge($node, $newNode);
        }

        return $node;
    }

    /**
     * Добавление элемента method со значением post для формирования атрибута data-method="post"
     * @param $node
     * @return array
     */
    protected function establishMethod($node)
    {
        if($node['url'] === '/logout'){
            $newNode = [
                'method' => 'post',
            ];
            return array_merge($node, $newNode);
        }

        return $node;
    }

}