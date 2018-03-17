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

<a href="<?=Url::toRoute(['board/view', 'id' => $model->id.'_'.$model->slug])?>" class="list-group-item  marked_<?=$model->marked?>">
    <div class="media">
        <p class="pull-left">
            <?=Html::img($model->showImage('100x100'), ['height'=>'100', 'width'=> '100'])?>
        </p>
        <div class="media-body">
            <h4 class="list-group-item-heading"><?=$model->name?> <small><?=$model->type->name?></small> </h4>
            <p class="text-muted"> <span class="glyphicon glyphicon-map-marker"></span> <?=$model->town->name?>  </p>

            <br />
            <?php if ($model->getPrice()) {
                echo '<p class="list-group-item-text">'.$model->price['name'].': <span class="label label-success">'.$model->price['cost'].'</span></p>';
            } ?>

            <p class="text-muted pull-right">Опубликовано: <strong><?= Yii::$app->formatter->asDate($model->started_at, "php: d M H:i ") ?></strong> </p>
        </div>
    </div>
</a>
<br />