<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Webinar]].
 *
 * @see \common\models\Webinar
 */
class WebinarQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Webinar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Webinar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
