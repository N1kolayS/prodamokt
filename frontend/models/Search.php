<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 06.03.17
 * Time: 23:30
 */


namespace frontend\models;



use common\models\Property;
use common\models\Town;
use common\models\Type;
use yii\base\Model;
use Yii;
use common\models\Board;
use common\models\BoardProperty;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;



class Search extends Board
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'type_id', 'town_id', 'views', 'looks', 'enable', 'marked'], 'integer'],
            [['name'], 'safe'],
            [['cost'], 'number'],
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
        $query = Board::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $this->setAttributes($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'type_id' => $this->type_id,
            'town_id' => $this->town_id,
            'cost' => $this->cost,
            'enable' => $this->enable,
            'marked' => $this->marked,
        ]);

        $query->andFilterWhere(['like', Board::tableName().'.name', $this->name]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,

                ]
            ],
        ]);

        return $dataProvider;
    }
}

