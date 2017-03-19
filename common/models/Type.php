<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $cost_name
 * @property integer $sort
 * @property integer $common_id
 *
 * @property Board[] $boards
 * @property Property[] $properties
 *
 * @property string $common
 */
class Type extends \yii\db\ActiveRecord
{

    const CATEGORY_PLACE   = 1;
    const CATEGORY_AUTO    = 2;
    const CATEGORY_ELECT   = 3;
    const CATEGORY_JOB     = 4;
    const CATEGORY_SERVICE = 5;
    const CATEGORY_STUFF   = 6;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort', 'common_id'], 'integer'],
            [['name', 'cost_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'cost_name' => 'Стоимость',
            'sort' => 'Сортировка',
            'common_id' => 'Раздел',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['type_id' => 'id']);
    }

    public static function ListCategory()
    {
        $data = [
            self::CATEGORY_PLACE   => 'Недвижимость',
            self::CATEGORY_AUTO    => 'Транспорт',
            self::CATEGORY_ELECT   => 'Электроника',
            self::CATEGORY_JOB     => 'Работа',
            self::CATEGORY_SERVICE => 'Услуги',
            self::CATEGORY_STUFF   => 'Вещи',

        ];
        return $data;
    }

    /**
     *
     */
    public function getCommon()
    {
        $array = self::ListCategory();
        return $array[$this->common_id];
    }

    /**
     * List all Types
     * @return array
     */
    public static function AllTypes()
    {
        $data = Type::find()->all();
        return ArrayHelper::map($data,'id','name');
    }

    /**
     * List all Types
     * @return array
     */
    public static function AllTypeSearch($css=false)
    {
        $data = Type::find()->all();
        $common = self::ListCategory();
        $allarr = [];

        // Name
        foreach ($common as $key => $value) {
            $allarr['common-' . $key] = $value;

            foreach ($data as $val) {
                if ($val->common_id == $key) {
                    $allarr[$val->id] = $val->name;
                }
            }
        }

        //CSS Options
        if ($css)
        {
            $allarr = [];
            foreach ($common as $key => $value) {
                $allarr['common-' . $key] = ['class' => 'opt'];

                foreach ($data as $val) {
                    if ($val->common_id == $key) {
                        $allarr[$val->id] = ['class' => 'basic'];
                    }
                }
            }

        }

        return $allarr;

        //$types = ArrayHelper::map($data,'id','name');
        /*
        $common = self::ListCategory();
        $allarr = [];
        foreach ($common as $key => $val)
        {
            $arr = [];
            foreach ($data as $value)
            {
                if ($value->common_id==$key)
                {
                    $arr[$value->id] = $value->name;
                }
            }
            $allarr[$val] = $arr;
        }
        return $allarr;
        */
    }
}
