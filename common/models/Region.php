<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $full_name
 * @property integer $default
 *
 * @property Town[] $towns
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'full_name'], 'required'],
            [['default'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['full_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Регион',
            'full_name' => 'Полное наименование',
            'default' => 'По умолчанию',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTowns()
    {
        return $this->hasMany(Town::className(), ['region_id' => 'id']);
    }

    /**
     * List all Regions
     * @return array
     */
    public static function AllRegions()
    {
        $data = Region::find()->all();
        return ArrayHelper::map($data,'id','name');
    }
}
