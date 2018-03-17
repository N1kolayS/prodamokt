<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 02.03.17
 * Time: 16:50
 */


namespace frontend\controllers;

use common\models\Board;
use common\models\Type;
use Intervention\Image\ImageManagerStatic;
use yii\helpers\Url;

use Intervention\Image\Image;




use Yii;
use yii\helpers\Json;
use common\models\Property;
use yii\web\Controller;
use yii\filters\AccessControl;


class AjaxController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['image-delete', 'image-add', 'image-create-add', 'image-create-delete'],
                'rules' => [
                    [
                        'actions' => ['image-delete', 'image-add', 'image-create-add', 'image-create-delete', 'image-create-rotate', 'image-rotate'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],

        ];
    }

    /**
     * JSON array of property Boards
     * @param $id
     */
    public function actionGetProperties($id)
    {
        if (Yii::$app->request->isAjax) {
            $id = intval($id);
            $type = Type::findOne($id);
            $prop = [];
            $properties =  Property::find()->where(['type_id' => $id])->orderBy('number')->all();
            foreach ($properties as $property)
            {
                $prop[] = array('id' => $property->id, 'mode' => $property->mode, 'val' => $property->generateMode->search());
            }
            echo Json::encode(['price'=>$type->cost_name, 'property' => $prop]);
        }
    }

    /**
     * JSON array of category Boars
     * @param $id
     */
    public function actionGetListTypes($id)
    {
        if (Yii::$app->request->isAjax) {
            $list_type = [];
            foreach (Type::find()->where(['common_id' => intval($id)])->orderBy('sort')->all() as $type)
            {
                $list_type[] = array('name' => $type->name, 'url' => Url::toRoute(['board/index', 'Search[type_id]' => $type->id]) );
            }
            echo Json::encode($list_type );
        }
    }


    /**
     * *******************************************************
     * Manage images on Create Boards
     * *******************************************************
     */

    /**
     * Add Images on Create
     *
     */
    public function actionImageCreateAdd()
    {
        if (Yii::$app->request->isAjax) {


            $result = false;
            $image = null;

            $ext = $this->CheckImage($_FILES[0]['tmp_name']); // File is valid Image

            if ($ext)
            {

                $tmp_user_dir = Board::createTmpDir();
                $name_file = uniqid().'.'.$ext;
                $path = $tmp_user_dir.$name_file;

                if ($this->resizeImage($_FILES[0]['tmp_name'], $path)) {

                    $image = ['name' => $name_file, 'url' => '/uploadimg/'.Yii::$app->user->id.'-tmp/'.$name_file];
                    $result = true;

                }

            }
            echo Json::encode(['success' => $result,  'image' => $image]);
        }
    }

    /**
     * Delete Images by Name image on Create
     *
     */
    public function actionImageCreateDelete()
    {
        if (Yii::$app->request->isAjax) {
            $name = Yii::$app->getRequest()->getQueryParam('name');
            $result = false;
            if (unlink(Yii::getAlias('@frontend/web/uploadimg/').Yii::$app->user->id.'-tmp/'.$name))
            {
                $result = true;
            }

            echo Json::encode(['success' => $result]);
        }
    }

    /**
     * Rotate Images by Name image on Create
     *
     */
    public function actionImageCreateRotate()
    {
        if (Yii::$app->request->isAjax) {
            $name = Yii::$app->getRequest()->getQueryParam('name');
            $result = false;
            $load_path =Yii::getAlias('@frontend/web/uploadimg/').Yii::$app->user->id.'-tmp/'.$name;
            if (file_exists($load_path))
            {
                $img = ImageManagerStatic::make($load_path);
                $img->rotate(90);
                $img->save();
                $result = true;
            }

            echo Json::encode(['success' => $result]);
        }
    }

    /**
     * *******************************************************
     *  Manage images on Update Boards
     * *******************************************************
     */

    /**
     * Delete Images by Id image on Update
     * @param $id
     */
    public function actionImageDelete($id)
    {
        if (Yii::$app->request->isAjax) {
            $id_image = intval(Yii::$app->getRequest()->getQueryParam('id_image'));
            $model = $this->findModelBoard($id);
            $result = false;
            if ($model)
            {
                foreach ($model->getImages() as $image)
                {
                    if ($image->id==$id_image)
                    {
                        $model->removeImage($image);
                        $result = true;
                    }

                }
            }

            echo Json::encode(['success' => $result]);
        }
    }



    /**
     * Add Images on Update
     * @param $id
     */
    public function actionImageAdd($id)
    {
        if (Yii::$app->request->isAjax) {

            $model = $this->findModelBoard($id);
            $result = false;
            $image = null;

            $ext = $this->CheckImage($_FILES[0]['tmp_name']); // File is valid Image

            if ($model&&$ext)
            {
                $name_file = uniqid().'.'.$ext;
                $path = Yii::getAlias('@frontend/web/uploadimg/').$name_file;
                if ($this->resizeImage($_FILES[0]['tmp_name'], $path)) {
                    $lastImage =  $model->attachImage($path, false, $model->id.'-'. $name_file);
                    $image = ['id' => $lastImage->id, 'url' => Board::fixPathImage($lastImage->getUrl('150x150'))];
                    $result = true;
                    unlink($path);
                }
                // ЗАКОМЕНТИТЬ ПОСЛЕ ОТЛАДКИ
                //usleep(2000000);
            }
            echo Json::encode(['success' => $result,  'image' => $image]);
        }
    }

    /**
     * Rotate Images by Id image on Create
     * @param $id
     */
    public function actionImageRotate($id)
    {
        if (Yii::$app->request->isAjax) {
            $id_image = intval(Yii::$app->getRequest()->getQueryParam('id_image'));
            $model = $this->findModelBoard($id);
            $result = false;
            $original_path = null;
            if ($model) {
                foreach ($model->getImages() as $image) {
                    if ($image->id == $id_image) {
                        $original_path =$image->getPathToOrigin();
                        $img = ImageManagerStatic::make($original_path);
                        $img->rotate(90);
                        $img->save();
                        $result = true;
                        $image->clearCache();
                    }

                }

            }

            //echo Json::encode(['success' => $result, 'path' => Yii::getAlias('@webroot')]);
            echo Json::encode(['success' => $result, 'path' => str_replace(Yii::getAlias('@webroot'), '', $original_path)]);
        }
    }

    /**
     * Finds the Board model based on its primary key value.
     * If the model is not found, return false
     * @param integer $id
     * @return Board the loaded model
     */
    protected function findModelBoard($id)
    {
        if (($model = Board::findOne($id)) !== null) {
            if ($model->user_id == Yii::$app->user->id) {
                return $model;
            }
        }
        return false;
   }

    /**
     * Check valid Image
     * @param $image
     * @return bool|string
     */
    protected function CheckImage($image)
    {

        switch (exif_imagetype($image)) {
            case IMAGETYPE_GIF:
                return 'gif';
                break;
            case IMAGETYPE_BMP:
                return 'bmp';
                break;
            case IMAGETYPE_PNG:
                return 'png';
                break;
            case IMAGETYPE_JPEG:
                return 'jpg';
                break;
            case IMAGETYPE_JPEG2000:
                return 'jpg';
                break;
            default:
                return false;
        }
    }

    /**
     * @param $load
     * @param $save
     * @return Image
     */
    protected function resizeImage($load, $save)
    {
        $img = ImageManagerStatic::make($load);
        $height = $img->getHeight();
        $width  = $img->getWidth();
        // Resize image by biggest size
        if ($width>$height) // Album
        {
            if ($width>800)
            {
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }
        else // Portrait
        {
            if ($height>800)
            {
                $img->resize(null, 800, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }
        return $img->save($save);
    }


}