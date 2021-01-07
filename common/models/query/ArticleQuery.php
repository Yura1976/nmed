<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Article]].
 *
 * @see \common\models\Article
 */
class ArticleQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    public function isinindex()
    {
        return $this->andWhere('[[isinindex]]=1');
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}