<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%board_property}}".
 *
 * @property integer $board_id
 * @property integer $property_id
 * @property string $value
 *
 * @property Board $board
 * @property Property $property
 */
class BoardProperty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%board_property}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['board_id', 'property_id'], 'required'],
            [['board_id', 'property_id'], 'integer'],
            [['value'], 'string', 'max' => 50],
            [['board_id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::className(), 'targetAttribute' => ['board_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'board_id' => 'Board ID',
            'property_id' => 'Property ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
}
