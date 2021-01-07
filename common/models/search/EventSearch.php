<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Event;

/**
 * EventSearch represents the model behind the search form of `common\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'access', 'rule', 'additionalFields', 'isEventRegAllowed', 'startsAt', 'endsAt', 'image', 'ownerId', 'defaultRemindersEnabled', 'eventId'], 'integer'],
            [['name', 'password', 'description', 'imagefile', 'type', 'lang', 'urlAlias', 'lectorIds', 'tags', 'duration', 'link'], 'safe'],
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
        $query = Event::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'name' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'access' => $this->access,
            'rule' => $this->rule,
            'additionalFields' => $this->additionalFields,
            'isEventRegAllowed' => $this->isEventRegAllowed,
            'startsAt' => $this->startsAt,
            'endsAt' => $this->endsAt,
            'image' => $this->image,
            'ownerId' => $this->ownerId,
            'defaultRemindersEnabled' => $this->defaultRemindersEnabled,
            'eventId' => $this->eventId,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'imagefile', $this->imagefile])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'urlAlias', $this->urlAlias])
            ->andFilterWhere(['like', 'lectorIds', $this->lectorIds])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
