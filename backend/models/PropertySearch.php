<?php

namespace backend\models;

use common\models\Type;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Property;
use yii\helpers\ArrayHelper;

/**
 * PropertySearch represents the model behind the search form about `common\models\Property`.
 */
class PropertySearch extends Property
{
    public $type;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'mode', 'number'], 'integer'],
            [['name', 'modelName', 'value', 'type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Property::find();
        $query->joinWith(['type']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['type'] = [

            'asc' => [Type::tableName().'.name' => SORT_ASC],
            'desc' => [Type::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'mode' => $this->mode,
            'number' => $this->number,
        ]);

        $query->andFilterWhere(['like', Property::tableName().'.name', $this->name])
            ->andFilterWhere(['like', Type::tableName().'.name', $this->type])
            ->andFilterWhere(['like', 'modelName', $this->modelName])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }

    public static function AllTypeGrid()
    {
        $data = Type::find()->all();
        return ArrayHelper::map($data,'name','name');
    }
}
