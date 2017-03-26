<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 26.03.17
 * Time: 11:42
 */


namespace frontend\models;

use common\models\Property;
use common\models\Town;
use common\models\Type;
use yii\base\Model;
use Yii;
use common\models\Board;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;


class SearchMy extends Board
{
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        parent::__construct();
    }
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
     *
     *
     * @return ActiveDataProvider
     */
    public function search()
    {

        $query = Board::find()->where(['user_id' => $this->user_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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

