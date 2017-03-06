<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%town}}".
 *
 * @property integer $id
 * @property integer $region_id
 * @property string $name
 * @property string $full_name
 * @property integer $default
 *
 * @property Region $region
 */
class Town extends \yii\db\ActiveRecord
{
    /**
     * Default Town
     */
    const DEFAULT_YES = 1;
    const DEFAULT_NO = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%town}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'name', 'full_name'], 'required'],
            [['region_id', 'default'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique',  'targetAttribute' => ['region_id', 'name']],
            [['full_name'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Регион',
            'region' => 'Регион',
            'name' => 'Наименование',
            'full_name' => 'Полное наименование',
            'default' => 'По умолчанию',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return array
     */
    public static function ListDefaults()
    {
        $data = [self::DEFAULT_YES => 'Да', self::DEFAULT_NO => 'Нет'];
        return $data;
    }

    /**
     * Array of Towns with opt group
     * @return array
     */
    public static function OptAllTowns()
    {
        $data = Town::find()->orderBy('region_id')->with('region')->all();
        $region = ArrayHelper::map($data,'region_id','region.name');

        $allarr = [];
        foreach ($region as $key=>$val)
        {
            $arr = [];
            foreach ($data as $value)
            {
                if ($value->region_id==$key)
                {
                    $arr[$value->id] = $value->name;
                }
            }
            $allarr[$val] = $arr;
        }
        return $allarr;
    }
}
