<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SubscribeUser]].
 *
 * @see \common\models\SubscribeUser
 */
class SubscribeUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\SubscribeUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\SubscribeUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
