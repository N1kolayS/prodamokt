<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 16.03.17
 * Time: 9:22
 */

namespace common\models;
use Yii;

class ModeRelation extends \yii\base\Object
{
    private $id;
    private $name;
    private $value;

    public function __construct($id, $name, $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public function Create()
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
     * Формирует JSON строку при создании записи
     */
    public function Record()
    {
        return null;
    }

    /**
     * Формирует input при поиске Объявления
     * @return string
     */
    public function Search()
    {
        return '<input id="property-'.$this->id .'" class="form-control" name="Board[property]['.$this->id .']" type="text">';
    }
}