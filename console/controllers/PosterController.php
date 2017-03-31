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
                        $image = Yii::getAlias('@frontend/web/images/').'logo0.png';
                    }

                    $vkApi = new Vk(['access_token' => Yii::$app->params['vk.token']]);
                    $vkApi->postToPublic(Yii::$app->params['vk.group'], $board->name.PHP_EOL. $board->body. PHP_EOL. Url::to(['board/view', 'id'=>$board->id]), $image);
                    Board::updateAll(['post_vk' => time()], ['id' => $board->id]);
                }

            }
        }

    }


}