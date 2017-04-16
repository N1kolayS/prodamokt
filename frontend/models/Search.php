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



class Search extends Model
{
    public $common_id;
    public $type_id;
    public $town_id;
    public $name;
    public $price_min;
    public $price_max;
    public $property;

    public function beforeValidate() {
        $this->price_min = str_replace(' ', null, $this->price_min);
        $this->price_max = str_replace(' ', null, $this->price_max);

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'town_id', 'common_id', ], 'integer'],
            [['name'], 'string'],
            [['property'], 'safe'],
            [['price_min', 'price_max'], 'string'],
        ];
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


        $time = time();
        $query->where(" `started_at` <= '$time' AND `finished_at` >= '$time' AND `enable`=". Board::STATUS_ENABLE);


        $this->load($params);

        if (!$this->validate())
        {
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




        if ($this->common_id)
        {
            $types = Type::find()->where(['common_id'=>$this->common_id])->asArray()->all();
            $query->andFilterWhere(['type_id' =>ArrayHelper::getColumn($types, 'id') ]);
        }
        // Property search
        if ($this->property)
        {


            foreach ($this->property as $key => $value)
            {
                if ($value!='')
                {
                    $query->andFilterWhere(['like', 'value'.$key, $value]);
                }
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'type_id' => $this->type_id,
            'town_id' => $this->town_id,
        ]);

        $query->andFilterWhere(['like', Board::tableName().'.name', $this->name]);

        if ($this->price_min!=0)
        {
            $query->andFilterWhere(['>=', 'cost', $this->price_min]);
        }

        if ($this->price_max!=0)
        {
            $query->andFilterWhere(['<=', 'cost', $this->price_max]);

        }



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

    /**
     * @return string
     */
    public function propertyToJs()
    {
        $array_js_property = '{}';
        if ($this->property)
        {
            $array_js_property = '{';
            foreach ($this->property as $key => $value)
            {
                $array_js_property .= $key.': "'. $value. '",';
            }
            $array_js_property .= '}';
        }
        return $array_js_property;
    }
}

