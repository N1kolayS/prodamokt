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

    public function actionVk()
    {
        $url = 'https://api.vk.com/method/photos.getWallUploadServer?group_id=150356587&access_token=fc61311fb6d83c6b67a5ae21efe7116cf261573a0d646feb0e8d4506e8fb4f4bf83eedd8f1dd54e89e714&v=3';
        echo $url.PHP_EOL;
        $result = json_decode($this->curl($url));

        var_dump($result);
    }

    /**
     * Make the curl request to specified url
     * @param string $url The url for curl() function
     * @return mixed The result of curl_exec() function
     * @throws \Exception
     */
    protected function curl($url)
    {
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // disable SSL verifying
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        // $output contains the output string
        $result = curl_exec($ch);

        if (!$result) {
            $error = curl_error($ch);
        }

        // close curl resource to free up system resources
        curl_close($ch);

        if (isset($errno) && isset($error)) {
            throw new \Exception($error, $errno);
        }

        return $result;
    }
}