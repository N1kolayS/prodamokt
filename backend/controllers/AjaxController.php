<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 16.03.17
 * Time: 9:50
 */


namespace backend\controllers;

use common\models\User;
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
                        'actions' => ['property-mode', 'user-activation', 'user-password-reset'],
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

    /**
     * Activate User
     */
    public function actionUserActivation()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->getRequest()->getQueryParam('id');
            if (($model = User::findOne($id)) !== null) {
                $model->Activate();
                echo Json::encode(['status' => 0]);
            }
        }
    }

    public function actionUserPasswordReset()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->getRequest()->getQueryParam('id');
            if (($model = User::findOne($id)) !== null) {

                $model->setPassword($model->phone);
                $model->save();
                echo Json::encode(['status' => 0]);
            }
        }
    }

}