<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 19.02.17
 * Time: 15:11
 */


namespace frontend\controllers;

use common\models\User;
use frontend\models\ChangePasswordForm;
use frontend\models\Search;
use frontend\models\SearchMy;
use frontend\models\SmsActivateForm;
use Yii;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;


/**
 * Site controller
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),

                'rules' => [

                    [
                        'actions' => ['cabinet', 'sms-activate', 'update', 'change-password'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays cabinet.
     *
     * @return mixed
     */
    public function actionCabinet()
    {
        $model = $this->findModel(Yii::$app->user->id);
        $boards = new SearchMy($model->id);
        $providerBoards = $boards->search();
        return $this->render('cabinet', [
            'model' => $model,
            'providerBoards' => $providerBoards,
        ]);
    }


    /**
     * Activate User with code from SMS
     *
     * @return mixed
     */
    public function actionSmsActivate()
    {
        $user = $this->findModel(Yii::$app->user->id);
        if ($user->isActivate())
        {
            return $this->goHome();
        }

        $model = new SmsActivateForm($user);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->Activate())
            {
                Yii::$app->session->setFlash('success', 'Ваш номер успешно подтвердился. Теперь вам доступны все возможности');
                return $this->redirect(['cabinet']);
            }

        }
        return $this->render('sms-activate', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['cabinet']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionChangePassword()
    {
        $model = new ChangePasswordForm($this->findModel(Yii::$app->user->id));
        if ($model->load(Yii::$app->request->post())) {
            if ($model->Change())
            {
                Yii::$app->session->setFlash('success', 'Ваш пароль успешно изменен');
                return $this->redirect(['cabinet']);
            }

        }
        return $this->render('change-password', [
            'model' => $model,
        ]);

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}