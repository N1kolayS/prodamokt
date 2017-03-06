<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%carprod}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $home
 *
 * @property Carmodel[] $carmodels
 */
class Carprod extends \yii\db\ActiveRecord
{
    /**
     * Отечественный автомобиль, или иномарка
     */

    const HOME_YES = 1;
    const HOME_NO = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%carprod}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['home'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
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
            'home' => 'Отечественный',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarmodels()
    {
        return $this->hasMany(Carmodel::className(), ['carprod_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function ListHome()
    {
        $data = [self::HOME_YES => 'Да', self::HOME_NO => 'Нет'];
        return $data;
    }

    /**
     * List all Cars Prod
     * @return array
     */
    public static function AllCarprod()
    {
        $data = Carprod::find()->all();
        return ArrayHelper::map($data,'id','name');
    }
}
