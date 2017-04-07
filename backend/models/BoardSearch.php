<?php

namespace backend\models;

use common\models\Town;
use common\models\Type;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Board;
use yii\helpers\ArrayHelper;

/**
 * BoardSearch represents the model behind the search form about `common\models\Board`.
 */
class BoardSearch extends Board
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

        $dataProvider->sort->attributes['user'] = [
            'asc' => [User::tableName().'.username' => SORT_ASC],
            'desc' => [User::tableName().'.username' => SORT_DESC],
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

            'views' => $this->views,
            'looks' => $this->looks,
            'enable' => $this->enable,
            'marked' => $this->marked,
        ]);

        $query->andFilterWhere(['like', Board::tableName().'.name', $this->name])
            ->andFilterWhere(['like', Town::tableName().'.name', $this->town])
            ->andFilterWhere(['like', User::tableName().'.username', $this->user])
            ->andFilterWhere(['like', Type::tableName().'.name', $this->type]);

        return $dataProvider;
    }

    public static function getAllTownGrid()
    {
        return ArrayHelper::map(Town::find()->all(),'name','name');
    }

    public static function getAllTypeGrid()
    {
        return ArrayHelper::map(Type::find()->all(),'name','name');
    }

}
