<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string $name_ru
 * @property int|null $country_id
 * @property int|null $region_id
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $region_type 1-страна,2-область/штат,3-город,4-пгт,5-пос,6-с,8-станица,9-д
 * @property int|null $parent_id
 * @property int $childrenreg
 * @property int $pos
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['country_id', 'region_id', 'status', 'region_type', 'parent_id', 'children', 'pos'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'country_id' => 'Country ID',
            'region_id' => 'Region ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'region_type' => 'Region Type',
            'parent_id' => 'Parent ID',
            'children' => 'Children',
            'pos' => 'Pos',
        ];
    }


    public function getRegionsList($id = '#',$all = false)
    {
        if($all === false):
            if ( $id == "#" || $id == 0) {
                $query = "
                    SELECT
                       id AS `id`,
                       IF ((parent_id IS NULL || parent_id=0), '#', parent_id) AS `parent`,
                       name,
                       children
                    FROM
                       region
                    WHERE parent_id IS NULL 
                        AND country_id = 0
                        AND status = 1
                    ORDER BY
                        pos ASC,
                        name
                ";
            }
            else{
                $query = "
                    SELECT
                       id AS `id`,
                       parent_id AS `parent`,
                       name,
                       children
                    FROM
                       region
                    WHERE `parent_id`=$id
                        AND status = 1
                    ORDER BY
                       `parent_id`
                       ,`name`
                ";
            }
        else:
            if ( $id == "#" || $id == 0) {
                $query = "
                    SELECT
                       id AS `id`,
                       IF ((parent_id IS NULL || parent_id=0), '#', parent_id) AS `parent`,
                       name,
                       children
                    FROM
                       region
                    WHERE parent_id IS NULL 
                        AND country_id = 0
                    ORDER BY
                        pos ASC,
                        name
                ";
            }
            else{
                $query = "
                    SELECT
                       id AS `id`,
                       parent_id AS `parent`,
                       name,
                       children
                    FROM
                       region
                    WHERE `parent_id`=$id
                    ORDER BY
                       `parent_id`
                       ,`name`
                ";
            }
        endif;

        $db = Yii::$app->db;

//        $data = $db->cache(function ($db) use($query) {
//            return $db->createCommand($query)->queryAll();
//        });
//        $data = $db->cache(function ($db) use($query) {
            return $db->createCommand($query)->queryAll();
//        });


        return $data;
    }

    public function appendTo($root)
    {
        $this->parent_id = $root->id;
//        $this->name = $root->name;
        if($root->country_id == 0) {
            $this->country_id = $root->id;
        } else {
            $this->country_id = $root->country_id;
        }
        if($root->children ==0){
            $root->children = 1;
            $root->save();
        }
        $this->status = 1;
        $this->pos = 150;
        if($this->save()) {
            return $this;
        } else {
            return false;
        }

    }


    /**
     * {@inheritdoc}
     * @return \common\models\query\RegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\RegionQuery(get_called_class());
    }
}
