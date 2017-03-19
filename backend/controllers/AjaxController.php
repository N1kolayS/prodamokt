<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 16.03.17
 * Time: 9:50
 */


namespace backend\controllers;

use Yii;
use yii\helpers\Json;
use common\models\Property;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AjaxController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),

                'rules' => [
                    [
                        'actions' => ['property-mode',],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     *
     */
    public function actionPropertyMode()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->getRequest()->getQueryParam('id');
            $property = new Property();
            $property->mode = $id;
            $result = array('record' => $property->generateMode->record());

            echo Json::encode($result);
        }
    }
}