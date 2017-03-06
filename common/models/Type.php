<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%type}}".
 *
 * @property integer $id
 * @property string $name
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
            [['name'], 'string', 'max' => 50],
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
}
