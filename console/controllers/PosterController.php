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
        $boards = Board::find()->where(['post_vk'=>null])->orderBy('started_at')->all();
        if ($boards)
        {
            foreach ($boards as $board)
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

                    //echo $board->name.PHP_EOL. $board->body. PHP_EOL;

                    $text = StringHelper::truncateWords($board->body, 70, '...');
                    $body =  $board->name.PHP_EOL.PHP_EOL. $text. PHP_EOL. PHP_EOL. 'Подробнее '. Url::to(['board/view', 'id'=>$board->id.'_'.$board->slug]);

                    $vkApi = new Vk(['access_token' => Yii::$app->params['vk.token']]);
                    $vkApi->postToPublic(Yii::$app->params['vk.group'], $body, $image, [$board->type->name.'@boxok', $board->town->name.'@boxok']);
                    //$vkApi->postToPublic(Yii::$app->params['vk.group'], $body, '');
                    Board::updateAll(['post_vk' => time()], ['id' => $board->id]);
                }

            }
        }

    }


}