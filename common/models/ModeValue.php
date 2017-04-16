<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 16.03.17
 * Time: 9:20
 */

namespace common\models;
use Yii;

class ModeValue extends \yii\base\Object
{
    private $id;
    private $name;
    private $value;
    private $number;

    public function __construct($id, $name, $value, $number)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->number = $number;
    }

    /**
     * Формирует input при создании Объявления
     * @return string
     */
    public function Create()
    {
        return '<input id="property-'.$this->id .'" class="form-control" name="Board[property]['.$this->number .']" type="text">';
    }

    public function Update($val)
    {
        return '<input id="property-'.$this->id .'" class="form-control" name="Board[property]['.$this->number .']" type="text" value="'. $val .'">';
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
        return '<input id="property-'.$this->id .'" class="form-control" name="Board[property]['.$this->number .']" type="text">';
    }
}