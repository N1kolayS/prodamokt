<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 06.03.17
 * Time: 23:36
 */

namespace app\components;

use common\models\Board;
use frontend\models\Search;
use yii\base\Widget;


class SearchWidget extends Widget {

    public $model;



    public function init () {

        parent::init();


        if ($this->model === null)
        {
            $this->model = new Search();
        }


    }

    public function run() {


            return $this->render('search',
                ['model' => $this->model]
            );

    }
}