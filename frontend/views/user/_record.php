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

<a href="<?=Url::toRoute(['user/board-view', 'id' => $model->id])?>" class="list-group-item  marked_<?=$model->marked?>">
    <div class="media">
        <div class="col-md-2">
            <?php
            $image = $model->getImage();
            if($image) {
                echo Html::img($image->getUrl('100x100'));
            }


            ?>
        </div>
        <div class="col-md-6">
            <div class="media-body">
                <h4 class="list-group-item-heading"><?=$model->name?> <small><?=$model->type->name?></small></h4>
                <p class="text-muted"> <span class="glyphicon glyphicon-map-marker"></span> <?=$model->town->name?>  </p>

                <br />
                <?php if ($model->getPrice()) {
                    echo '<p class="list-group-item-text">'.$model->price['name'].': <span class="label label-success">'.$model->price['cost'].'</span></p>';
                } ?>

            </div>
        </div>
        <div class="col-md-4">
            <p class="text-muted text-right">Просмотры <span class="glyphicon glyphicon-eye-open"></span> <?=$model->views?> </p>
            <p class="text-muted text-right"><?php if ($model->isStarted()) { echo 'Опубликовано: <strong>'. Yii::$app->formatter->asDate($model->started_at, "php: d M H:i ").'</strong>'; } else { echo 'Активируется через: <strong>'. intval(($model->started_at-time())/60).'</strong> минут'; }  ?>  </p>
            <p class="text-muted text-right"><?php if ($model->isFinished()) { echo 'Истекло'; } else { echo 'Истекает: <strong>'. Yii::$app->formatter->asDate($model->finished_at, "php: d M H:i ").'</strong>'; } ?></p>
        </div>


    </div>
</a>
<br />