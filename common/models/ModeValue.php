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

    public function __construct($id, $name, $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Формирует input при создании Объявления
     * @return string
     */
    public function Create()
    {
        return '<input id="property-'.$this->id .'" class="form-control" name="Board[property]['.$this->id .']" type="text">';
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