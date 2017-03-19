<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 02.03.17
 * Time: 16:50
 */


namespace frontend\controllers;

use common\models\Board;
use Yii;
use yii\helpers\Json;
use common\models\Property;
use yii\web\Controller;


class AjaxController extends Controller {



    /*
     * JSON array of property Ads
     */
    public function actionGetProperties($id)
    {
        if (Yii::$app->request->isAjax) {

            $properties =  Property::find()->where(['type_id' => $id])->all();

            $result = [];

            foreach ($properties as $property)
            {
                $result[] = array('id' => $property->id, 'mode' => $property->mode, 'val' => $property->generateMode->search());
            }
            echo Json::encode($result);
        }
    }

    public function actionGetphone($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = Board::findOne($id);
            $model->updateCounters(['views' => 1]);
            $result = ['phone' => $model->idUser->phone];
            echo Json::encode($result);
        }
    }
}