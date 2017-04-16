<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 19.02.17
 * Time: 15:11
 */

namespace frontend\controllers;

use common\models\Board;
use common\models\Property;
use common\models\User;
use frontend\models\ChangePasswordForm;
use frontend\models\SearchMy;
use frontend\models\SmsActivateForm;
use Yii;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * User controller
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
                        'actions' => ['cabinet', 'sms-activate', 'update', 'change-password', 'board-view', 'board-delete', 'board-update', 'board-on', 'board-off', 'board-prolong'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'board-delete' => ['post'],
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
        $model = $this->findModel();
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
        $user = $this->findModel();
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
        $model = $this->findModel();

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
        $model = new ChangePasswordForm($this->findModel());
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
     ******************************************************************** 
     * Manage users boards
     ********************************************************************
     */

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBoardView($id)
    {
        $model = $this->findModelBoard($id);

        return $this->render('board-view', [
            'model' => $model,
            'properties' => Property::find()->where(['type_id' => $model->type_id])->orderBy('number')->all(),
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionBoardDelete($id)
    {
        $this->findModelBoard($id)->delete();

        return $this->redirect(['cabinet']);
    }


    /**
     * Enable select Board
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionBoardOn($id)
    {
        $model = $this->findModelBoard($id);
        $model->enable = Board::STATUS_ENABLE;
        $model->save();

        return $this->redirect(['board-view', 'id' => $id]);
    }

    /**
     * Disable select Board
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionBoardOff($id)
    {
        $model = $this->findModelBoard($id);
        $model->enable = Board::STATUS_DISABLE;
        $model->save();

        return $this->redirect(['board-view', 'id' => $id]);
    }

    /**
     * Prolong select Board
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionBoardProlong($id)
    {
        $model = $this->findModelBoard($id);
        if ($model->isFinished())
        {
            $model->Prolong();
            $model->save();
        }
        return $this->redirect(['board-view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionBoardUpdate($id)
    {
        $model = $this->findModelBoard($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->correctImages();
            return $this->redirect(['board-view', 'id' => $model->id]);
        } else {
            return $this->render('board-update', [
                'model' => $model,
                'properties' => Property::find()->where(['type_id' => $model->type_id])->orderBy('number')->all(),
            ]);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = User::findOne(Yii::$app->user->id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Board model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Board the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBoard($id)
    {
        if (($model = Board::findOne($id)) !== null) {
           if ($model->user_id == Yii::$app->user->id)
           {
               return $model;
           }
            else
            {
                throw new NotFoundHttpException('У вас нет прав для просмотра этого объявления.');
            }
        } else {
            throw new NotFoundHttpException('Объявление не найдено.');
        }
    }
}