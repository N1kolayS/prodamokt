<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 31.03.17
 * Time: 23:52
 */

namespace console\controllers;


use Yii;
use yii\console\Controller;


class DummyController extends Controller {

    public function actionTest()
    {

        $file = Yii::getAlias('@frontend/web/uploadimg/').'/dummy.txt';


        $fp = fopen ($file, "a");
        fwrite($fp,date('H:i:s').PHP_EOL);
        fclose($fp);

    }
}