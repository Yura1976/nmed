<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'data_show', 'isinindex', 'status', 'views', 'comments_count'], 'integer'],
            [['name', 'annot_text', 'detail_text', 'annonce_img', 'detail_img', 'meta_title', 'meta_keywords', 'meta_description', 'slug'], 'safe'],
            [['rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = Article::find();
        if($params['category_slug']) {
            $query = $query->innerJoinWith('articleCategories', true)
                ->where(['article_category.slug' => $params['category_slug']]);
        }
//        var_dump($query->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'data_show' => $this->data_show,
            'isinindex' => $this->isinindex,
            'status' => $this->status,
            'views' => $this->views,
            'rate' => $this->rate,
            'comments_count' => $this->comments_count,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'annot_text', $this->annot_text])
            ->andFilterWhere(['like', 'detail_text', $this->detail_text])
            ->andFilterWhere(['like', 'annonce_img', $this->annonce_img])
            ->andFilterWhere(['like', 'detail_img', $this->detail_img])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
