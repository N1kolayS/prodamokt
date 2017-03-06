<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 06.03.17
 * Time: 23:36
 */

namespace app\components;

use yii\base\Widget;


class SearchWidget extends Widget {

    public $search;



    public function init () {

        parent::init();


        if ($this->search === null)
        {
            $this->search = false;
        }


    }

    public function run() {
        if (($this->search))
        {

            return $this->render('search',
                ['model' => $this->search]
            );
        }
    }
}