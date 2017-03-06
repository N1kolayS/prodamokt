<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%carmodel}}".
 *
 * @property integer $id
 * @property integer $carprod_id
 * @property string $name
 *
 * @property Carprod $carprod
 */
class Carmodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%carmodel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carprod_id', 'name'], 'required'],
            [['carprod_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique',  'targetAttribute' => ['carprod_id', 'name']],
            [['carprod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carprod::className(), 'targetAttribute' => ['carprod_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'carprod_id' => 'Автопроизводитель',
            'name' => 'Наименование',
            'carprod' => 'Автопроизводитель',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarprod()
    {
        return $this->hasOne(Carprod::className(), ['id' => 'carprod_id']);
    }
}
