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
    public $common_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'type_id', 'town_id', 'common_id', 'views', 'looks', 'enable', 'marked'], 'integer'],
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

        $this->setAttributes($params);

        if ($this->common_id)
        {
            $types = Type::find()->where(['common_id'=>$this->common_id])->asArray()->all();
            //echo var_dump(ArrayHelper::getColumn($types, 'id'));
            $query = Board::find()->where(['type_id' => ArrayHelper::getColumn($types, 'id')]);
        }
        else
        {
            $query = Board::find();
        }
        $time = time();
        $query->where(" `started_at` <= '$time' AND `finished_at` >= '$time' AND `enable`=1");


        // grid filtering conditions
        $query->andFilterWhere([
            'type_id' => $this->type_id,
            'town_id' => $this->town_id,
            'cost' => $this->cost,

        ]);

        $query->andFilterWhere(['like', Board::tableName().'.name', $this->name]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'started_at' => SORT_DESC,

                ]
            ],
        ]);

        return $dataProvider;
    }
}

