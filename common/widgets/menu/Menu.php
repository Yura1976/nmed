<?php
namespace common\widgets\menu;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\Menu as MenuYii;

class Menu extends MenuYii
{
    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            $params = explode('=',$item['params']);
            $itemparams = [];
            if(is_array($params) && isset($item['params'])){
                $itemparams[$params[0]] = $params[1];
            }
            return strtr($template, [
                '{url}' => (isset($itemparams)) ? Html::encode(Url::to(array_merge([$item['url']],$itemparams))) : Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{method}' => isset($item['method']) ? $item['method'] : 'get', //добавляем атрибут data-method
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }
}