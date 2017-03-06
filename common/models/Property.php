<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%property}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type_id
 * @property integer $mode
 * @property string $modelName
 * @property string $value
 * @property integer $sort
 *
 * @property BoardProperty[] $boardProperties
 * @property Board[] $boards
 * @property Type $type
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
            [['name', 'type_id'], 'required'],
            [['type_id', 'mode', 'sort'], 'integer'],
            [['name', 'modelName'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 255],
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
            'sort' => 'Сортировка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoardProperties()
    {
        return $this->hasMany(BoardProperty::className(), ['property_id' => 'id']);
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
     * @return string
     */
    private function modeList()
    {

        $input = '<select  class="form-control" name="Board[property]['. $this->id .']">';
        foreach (explode(';', $this->value) as $value)
        {
            if (trim($value)=='0')
            {
                $input = $input. '<option value="">- Выберите: '. $this->name .' -</option>';
            }
            else
            {
                $input = $input. '<option value = "'. trim($value) .'">'. trim($value) .'</option>';
            }
        }
        return $input. '</select>';

    }

    /**
     * @return string
     */
    private function modeMulti()
    {

        $input = '<select  class="form-control" name="Board[property]['. $this->id .']">';
        foreach (explode(';', $this->value) as $value)
        {
            if (trim($value)=='0')
            {
                $input = $input. '<option value="">- Выберите: '. $this->name .' -</option>';
            }
            else
            {
                $input = $input. '<option value = "'. trim($value) .'">'. trim($value) .'</option>';
            }

        }
        return $input. '</select>';

    }

    /**
     * @return string
     */
    private function modeRange()
    {

        $input = '<select  class="form-control" name="Board[property]['. $this->id .']">';

        $data = Json::decode($this->value);
        //return var_dump($data);
        #/*
        $step = $data['start'];
        for ($i = $data['start']; $i<$data['stop']+1; $i++)
        {
            $input = $input. '<option >'. $step .'</option>';
            $step+= $data['step'];
        }
        return $input. '</select>';
#*/
    }


    /**
     *
     * @return null|string
     */
    public function generateCreate()
    {
        switch ($this->mode) {
            case self::MODE_VALUE:
                $result = '<input id="property-'.$this->id .'" class="form-control" name="Board[property]['.$this->id .']" type="text">';
                break;
            case self::MODE_RANGE:
                $result = $this->modeRange();
                break;
            case self::MODE_LIST:
                $result = $this->modeList();
                break;
            case self::MODE_MULTI:
                $result = $this->modeMulti();
                break;
            default:
                $result = '<input id="property-'.$this->id .'" class="form-control" name="Board[property]['.$this->id .']" type="text">';
        }
        return $result;
    }
}
