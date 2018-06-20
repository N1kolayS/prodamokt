<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 31.03.17
 * Time: 1:18
 */

namespace console\controllers;


use common\models\Board;
use common\models\Vk;
use Yii;
use yii\console\Controller;
use yii\helpers\StringHelper;
use yii\helpers\Url;


class PosterController extends Controller {

    public function actionAll()
    {


        foreach ($this->findBoards() as $board)
        {
            if ($board->isActive())
            {

                if ($board->existImages())
                {
                    $image = $board->getImage()->getPath();
                }
                else
                {
                    $image = Yii::getAlias('@frontend/web/images/').'logo.png';
                }

                echo $board->name.PHP_EOL. $board->body. PHP_EOL;

                $text = StringHelper::truncateWords($board->body, 70, '...');
                $body =  $board->name.PHP_EOL.PHP_EOL. $text. PHP_EOL. PHP_EOL. 'Подробнее '. Url::to(['board/view', 'id'=>$board->id.'_'.$board->slug]);

                $vkApi = new Vk(['access_token' => Yii::$app->params['vk.token']]);
                $vkApi->postToPublic(Yii::$app->params['vk.group'], $body, $image, [$this->cleanTag($board->type->name).'@boxok', $this->cleanTag($board->town->name).'@boxok']);

                Board::updateAll(['post_vk' => time()], ['id' => $board->id]);
            }

        }


    }


    protected function cleanTag($tag)
    {
        return str_replace([',', '.', '!', '/', '`', '<', '>', '?', '-', '+', '='], '', $tag);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]|Board[]
     */
    private function findBoards()
    {
        return  Board::find()->where(['post_vk'=>null])->orderBy('started_at')->all();
    }

    public function actionTest()
    {



                   $image = Yii::getAlias('@frontend/web/images/').'logo.png';
                  // $image = 'https://boxok.ru/yii2images/images/image-by-item-and-alias?item=Board106&dirtyAlias=0d4dbfedf5-1_450x.jpg';

              // echo Yii::getAlias('@frontend/web/images/').'logo.png';
                //echo $board->name.PHP_EOL. $board->body. PHP_EOL;


                $body = 'test';

            $vkApi = new Vk(['access_token' => Yii::$app->params['vk.token']]);
               // $vkApi->postToPublic(Yii::$app->params['vk.group'], $body, $image );
                $vkApi->postToPublic(Yii::$app->params['vk.group'], $body, $image);


    }


}