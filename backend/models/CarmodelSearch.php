<?php

namespace backend\models;

use common\models\Carprod;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Carmodel;
use yii\helpers\ArrayHelper;

/**
 * CarmodelSearch represents the model behind the search form about `common\models\Carmodel`.
 */
class CarmodelSearch extends Carmodel
{
    public $carprod;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'carprod_id'], 'integer'],
            [['name', 'carprod'], 'safe'],
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
        $query = Carmodel::find();
        $query->joinWith(['carprod']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->sort->attributes['carprod'] = [
            'asc' => [Carprod::tableName().'.name' => SORT_ASC],
            'desc' => [Carprod::tableName().'.name' => SORT_DESC],
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
            'carprod_id' => $this->carprod_id,
        ]);

        $query->andFilterWhere(['like', Carmodel::tableName().'.name', $this->name])
        ->andFilterWhere(['like', Carprod::tableName().'.name', $this->carprod]);

        return $dataProvider;
    }

    public static function AllCarprodGrid()
    {
        $data = Carprod::find()->all();
        return ArrayHelper::map($data,'name','name');
    }

}
