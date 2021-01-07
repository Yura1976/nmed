<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $name
 * @property string $config_type
 * @property string|null $config_value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['config_type', 'config_value'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование параметра',
            'config_type' => 'Тип',
            'config_value' => 'Значение',
        ];
    }

    public function getConfig($id)
    {
        if($id) {
            $config = Config::findOne($id);
            if($config) $val = $config->config_value;
            else $val = '';
        } else {
            $val = '';
        }
        return $val;
    }


    /**
     * {@inheritdoc}
     * @return \common\models\query\ConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ConfigQuery(get_called_class());
    }
}
