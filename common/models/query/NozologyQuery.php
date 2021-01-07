<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Nozology]].
 *
 * @see \common\models\Nozology
 */
class NozologyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Nozology[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Nozology|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
