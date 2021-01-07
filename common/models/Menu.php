<?php
namespace common\models;

use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $name
 */

class Menu extends \yii\db\ActiveRecord
{

//    public $url;

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
            [['name'], 'required'],
            [['lft', 'rgt', 'depth'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string'],
            [['params'], 'string'],
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
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Уровень (0-корень)',
            'published' => 'Опубликовано',
            'params' => 'Параметры',
            'menuplace' => 'Расположение',
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


    public function getMenuPlaceArray()
    {
        return [
          'top' => 'Верхнее меню',
          'footer' => 'Меню в футере'
        ];
    }


    public static function find()
    {
        return new \common\models\query\MenuQuery(get_called_class());
    }
}