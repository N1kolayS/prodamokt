<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 06.03.17
 * Time: 23:53
 */


/* @var $model common\models\Board */

use yii\helpers\Url;
use yii\bootstrap\Html;

?>

<a href="#" class="list-group-item  marked_<?=$model->marked?>">
    <div class="media">
        <p class="pull-left">
            <?php
            $image = $model->getImage();
            if($image) {
                echo Html::img($image->getUrl('x200'));
            }

            ?>
        </p>
        <div class="media-body">
            <h4 class="list-group-item-heading"><?=$model->name?> <small><?=$model->type->name?></small></h4>
            <p  class="list-group-item-text"><span class="glyphicon glyphicon-map-marker"></span> <?=$model->town->name?>  </p>
            <br />
            <p class="list-group-item-text">Цена: <span class="label label-success"><?php if ($model->cost) echo Yii::$app->formatter->asCurrency($model->cost); else echo 'Не указана'; ?></span> </p>
            <p class="text-muted pull-right">Опубликовано: <strong><?= Yii::$app->formatter->asDate($model->created_at, "php: d M H:i ") ?></strong> </p>
        </div>
    </div>
</a>
<br />