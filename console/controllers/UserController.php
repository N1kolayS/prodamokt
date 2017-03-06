<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 19.02.17
 * Time: 12:05
 */

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;


class UserController extends Controller {

    public function actionCreate($password)
    {
        $user = new User();
        $user->username = 'Administrator';
        $user->email = 'shayahmetov@gmail.com';
        $user->phone = '9613603024';
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->role = User::ROLE_ADMIN;



        if ($user->save()) {
            Yii::$app->authManager->revokeAll($user->id);
            $userRole = Yii::$app->authManager->getRole(User::ROLE_ADMIN);
            Yii::$app->authManager->assign($userRole, $user->id);
            $user->updateAll(['role' => User::ROLE_ADMIN], $user->id);
            echo $user->username. PHP_EOL;

        }
        else
        {
            echo var_dump($user->errors);
        }

    }
}