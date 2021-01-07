<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\WebinarCategory]].
 *
 * @see \common\models\WebinarCategory
 */
class WebinarCategoryQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * {@inheritdoc}
     * @return \common\models\WebinarCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\WebinarCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
