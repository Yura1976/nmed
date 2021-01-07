<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Webinar;

/**
 * WebinarSearch represents the model behind the search form of `common\models\Webinar`.
 */
class WebinarSearch extends Webinar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','eventId', 'eventIdnkomed', 'access', 'utcStartsAt', 'createUserId', 'timezoneId', 'organizationId', 'image', 'eventsessionId', 'urlAlias', 'duration'], 'integer'],
            [['from_date','to_date','name', 'status', 'lang', 'startsAt', 'endsAt', 'type', 'description', 'bgimage', 'searchworld','webinarcategoryids'], 'safe'],
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
        $query = Webinar::find();
//var_dump($params);
        if($category_id = $params["WebinarSearch"]["webinarcategoryids"]){
            if(is_string($category_id)) {
                $query = $query
                    ->joinWith('webinarCategoryWebinars')
                    ->andWhere(['category_id' => $category_id]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                    'name' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
             $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'access' => $this->access,
            'utcStartsAt' => $this->utcStartsAt,
            'createUserId' => $this->createUserId,
            'timezoneId' => $this->timezoneId,
            'organizationId' => $this->organizationId,
            'image' => $this->image,
            'eventsessionId' => $this->eventsessionId,
            'urlAlias' => $this->urlAlias,
            'duration' => $this->duration,
            'eventId' => $this->eventId,
            'eventIdnkomed' => $this->eventIdnkomed,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'startsAt', $this->startsAt])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['OR',['like', 'name', $this->searchworld],['like', 'description', $this->searchworld]])
            ->andFilterWhere(['like', 'description', $this->description]);
        if($this->from_date) {
            $query->andFilterWhere(['>=', 'startsAt', strtotime($this->from_date)]);
        }
        if($this->to_date) {
            $query->andFilterWhere(['<=', 'startsAt', strtotime($this->to_date)]);
        }
//        var_dump($query->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        return $dataProvider;
    }
}
