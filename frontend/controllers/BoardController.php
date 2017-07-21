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
use common\models\Town;
use common\models\Type;
use common\models\User;
use frontend\models\Search;
use Yii;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * Board controller
 */
class BoardController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['step' ,'create'],
                'rules' => [

                    [
                        'actions' => ['step', 'create'],
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
     * @return string
     */
    public function actionIndex()
    {
        $model = new Search();
        $dataProvider = $model->search(Yii::$app->request->get());

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionView($id)
    {
        $id = strpos($id, '_') ? (int) substr($id, 0, strpos($id, '_') ) : $id;
        //echo var_dump($id);
        $model = $this->findModel($id);
        $model->updateView();
        return $this->render('view', [
            'model' => $model,
            'properties' => Property::find()->where(['type_id' => $model->type_id])->orderBy('number')->all(),
        ]);

    }

    /**
     * Display first step for create Ad
     *
     * @return mixed
     */
    public function actionStep()
    {
        $list_types = Type::find()->orderBy('sort')->all();
        $list_category = Type::ListCategory();
        Board::deleteTmpDir();
        return $this->render('step', [
            'list_types' => $list_types,
            'list_category' => $list_category,
        ]);
    }

    /**
     * Displays second step for create Ad
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        $type_id =  intval($id);


        $model_type = $this->findModelType($type_id);

        $model = new Board();
        $model->type_id = $type_id;

        $property_list = Property::find()->where(['type_id'=> $type_id])->orderBy('number')->all();
        if ($model->load(Yii::$app->request->post())&& $model->save() ) {


            $model->images = UploadedFile::getInstances($model, 'images');
            $scan_dir = Board::scanDirImages();
            if ($scan_dir)
            {
                foreach ($scan_dir['files'] as $file) {
                    $path = $scan_dir['path'].$file;
                    $model->attachImage($path,  false, $model->id.'-'. $file);
                }
            }
            Board::deleteTmpDir();

            Yii::$app->session->setFlash('success', 'Объявление <strong>'. $model->name .'</strong> успешно добавлено');
            return $this->redirect(['user/cabinet']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_type' => $model_type,
                'property_list' => $property_list,
            ]);
        }

    }

    /**
     * Finds the Type model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Type the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelType($id)
    {
        if (($model = Type::findOne($id)) !== null) {
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
    protected function findModel($id)
    {
        if (($model = Board::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}