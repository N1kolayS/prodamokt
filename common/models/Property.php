<?php

namespace common\models;

use Yii;


/**
 * This is the model class for table "{{%property}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type_id
 * @property integer $mode
 * @property string $modelName
 * @property string $value
 * @property integer $number
 *
 * @property BoardProperty[] $boardProperties
 * @property Board[] $boards
 * @property Type $type
 *
 * @property Object $generateMode
 */
class Property extends \yii\db\ActiveRecord
{

    /**
     * Виды свойств
     */
    const MODE_VALUE    = 0; // Обычное значение
    const MODE_RANGE    = 1; // Диапазон
    const MODE_LIST     = 2; // Список
    const MODE_MULTI    = 3; // Мультивыбор
    const MODE_RELATION = 4; // Связь с моделью


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id', 'number'], 'required'],
            [['type_id', 'mode', 'number'], 'integer'],
            [['name', 'modelName'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 255],
            [['number'], 'unique',   'targetAttribute' => ['type_id', 'number'] ],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'type_id' => 'Тип объявления',
            'type' => 'Тип объявления',
            'mode' => 'Режим',
            'modelName' => 'Модель',
            'value' => 'Значения',
            'number' => 'Номер свойства',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['id' => 'board_id'])->viaTable('{{%board_property}}', ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
     * Варианты параметров
     * @return array
     */
    public static function ListMode()
    {
        $data = [
            self::MODE_VALUE    => 'Простое значение',
            self::MODE_RANGE    => 'Диапазон',
            self::MODE_LIST     => 'Список',
            self::MODE_MULTI    => 'Мультивыбор',
            self::MODE_RELATION => 'Связь с моделью',
        ];
        return $data;
    }

    /**
     * @return array
     */
    public static function ListNumber()
    {
        return [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 =>8
        ];
    }

    /**
     *
     * @return null|string
     */
    public function getGenerateMode()
    {
        switch ($this->mode) {
            case self::MODE_VALUE:
                $modeObject = new ModeValue($this->id, $this->name, $this->value, $this->number);
                break;
            case self::MODE_RANGE:
                $modeObject = new ModeRange($this->id, $this->name, $this->value, $this->number);
                break;
            case self::MODE_LIST:
                $modeObject = new ModeList($this->id, $this->name, $this->value, $this->number);
                break;
            case self::MODE_MULTI:
                $modeObject = new ModeMulti($this->id, $this->name, $this->value, $this->number);
                break;
            default:
                $modeObject = new ModeValue($this->id, $this->name, $this->value, $this->number);
        }
        return $modeObject;
    }
}
