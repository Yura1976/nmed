<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Speaker]].
 *
 * @see \common\models\Speaker
 */
class SpeakerQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }
    public function inindex()
    {
        return $this->andWhere('[[inindex]]=1');
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Speaker[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Speaker|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
