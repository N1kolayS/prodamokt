<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 16.03.17
 * Time: 9:04
 */

namespace common\models;
use Yii;
use yii\helpers\Json;

class ModeList extends \yii\base\Object
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

    public function Create()
    {

        $data = Json::decode($this->value);
        if (array_key_exists('prompt', $data)&&array_key_exists('list', $data))
        {
            $input = '<select  class="form-control" name="Board[property]['. $this->number .']">';
            if ($data['prompt'])
            {
                $input = $input. '<option value="">- Выберите: '. $this->name .' -</option>';
            }
            foreach ($data['list'] as $value)
            {
                $input = $input. '<option value = "'. trim($value) .'">'. trim($value) .'</option>';
            }
            return $input. '</select>';
        }
        else
            return null;

        #*/
    }

    public function Update($val)
    {

        $data = Json::decode($this->value);
        if (array_key_exists('prompt', $data)&&array_key_exists('list', $data))
        {
            $input = '<select  class="form-control" name="Board[property]['. $this->number .']">';
            if ($data['prompt'])
            {
                $select_prompt = '';
                if ($val==0)
                    $select_prompt = 'selected';

                $input = $input. '<option value="" '. $select_prompt .'>- Выберите: '. $this->name .' -</option>';
            }
            foreach ($data['list'] as $value)
            {
                $select = '';
                if ($val == trim($value))
                    $select = 'selected';
                $input = $input. '<option value = "'. trim($value) .'" '. $select .'>'. trim($value) .'</option>';
            }
            return $input. '</select>';
        }
        else
            return null;

        #*/
    }

    /**
     * Формирует JSON строку при создании записи
     */
    public function Record()
    {
        return '{"prompt":false,"list":[]}';
    }

    /**
     * Формирует input при поиске Объявления
     * @return string
     */
    public function Search()
    {

        $data = Json::decode($this->value);
        if (array_key_exists('prompt', $data)&&array_key_exists('list', $data))
        {

            $prompt = $data['prompt'] ? $data['prompt'] : '- Все варианты -';

            return ['type' => 'list', 'prompt'=>$prompt, 'number'=>$this->number, 'list' => $data['list']];
        }
        else
            return null;
    }
}