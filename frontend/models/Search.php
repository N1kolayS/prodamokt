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
    public $town;
    public $type;
    public $user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type_id', 'town_id', 'created_at', 'updated_at', 'views', 'looks', 'enable', 'marked'], 'integer'],
            [['name', 'body', 'town', 'type', 'user'], 'safe'],
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
        $query->joinWith(['town', 'type', 'user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['town'] = [
            'asc' => [Town::tableName().'.name' => SORT_ASC],
            'desc' => [Town::tableName().'.name' => SORT_DESC],
        ];

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
            'user_id' => $this->user_id,
            'type_id' => $this->type_id,
            'town_id' => $this->town_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'cost' => $this->cost,
            'views' => $this->views,
            'looks' => $this->looks,
            'enable' => $this->enable,
            'marked' => $this->marked,
        ]);

        $query->andFilterWhere(['like', Board::tableName().'.name', $this->name])
            ->andFilterWhere(['like', Town::tableName().'.name', $this->town])

            ->andFilterWhere(['like', Type::tableName().'.name', $this->type]);

        return $dataProvider;
    }
}

