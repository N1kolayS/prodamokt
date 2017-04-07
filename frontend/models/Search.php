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
        $this->price_min = intval(str_replace(' ', null, $this->price_min));
        $this->price_max = intval(str_replace(' ', null, $this->price_max));

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'type_id', 'town_id', 'common_id', ], 'integer'],
            [['name'], 'string'],
            [['property'], 'safe'],
            [['price_min', 'price_max'], 'decimalNumber'],
        ];
    }

    public function decimalNumber($attribute)
    {
        if (!preg_match('/^[0-9]$/', $this->$attribute)) {
            $this->addError($attribute, 'Только цифры');
        }
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

        $this->validate($params);

        $query = Board::find();

        $time = time();
        $query->where(" `started_at` <= '$time' AND `finished_at` >= '$time' AND `enable`=". Board::STATUS_ENABLE);
        if ($this->common_id)
        {
            $types = Type::find()->where(['common_id'=>$this->common_id])->asArray()->all();
            $query->andFilterWhere(['type_id' =>ArrayHelper::getColumn($types, 'id') ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'type_id' => $this->type_id,
            'town_id' => $this->town_id,
        ]);

        $query->andFilterWhere(['like', Board::tableName().'.name', $this->name]);

        if (($this->price_max!=0)&&($this->price_min!=0))
        {
            $query->andFilterWhere(['>', 'cost', $this->price_min]);
            $query->andFilterWhere(['<', 'cost', $this->price_max]);
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
}

