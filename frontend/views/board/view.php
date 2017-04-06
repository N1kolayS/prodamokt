<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 09.03.17
 * Time: 8:47
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Board */

$this->title = $model->name;


$this->params['breadcrumbs'][] = ['label' => $model->type->name, 'url' => [
    '/board/index',
    'Search' =>['type_id' => $model->type_id,  'name'=> '',  'price_min' => '', 'price_max' => '']
]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

function loadimg(idimg)
{
        $("#MainImg").empty();
        $("#MainImg").html('<img src="'+idimg+'" />');
}

JS;

$this->registerJs($script, yii\web\View::POS_END);

?>
<div class="board-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-5">
            <?php

            if ($model->existImages())
            {
                $image = $model->getImage();
                echo '<div id="MainImg">'.Html::img($image->getUrl('450x'), ['class' => 'img-responsive']).'</div>';

            }
            ?>
        </div>
        <div class="col-md-2">
            <?php
            if ($model->existImages())
            {
                echo '<ul class="list-group list-image">';
                foreach ($model->getImages() as $img)
                {
                    $big_img = $img->getUrl('450x');
                    echo '<li class="list-group-item text-center">'.Html::img($img->getUrl('100x100'), [
                            'class' => 'img-rounded',
                            'onclick' => "loadimg('$big_img')"
                        ]).'</li>';

                }
                echo '</ul>';
            }

            ?>
        </div>

        <div class="col-md-5">
            <p class="lead">Цена: <span class="label label-success"><?php if ($model->cost) echo Yii::$app->formatter->asCurrency($model->cost); else echo 'Не указана'; ?></span></p>
            <p class="lead"> Продавец: <strong><?=$model->user->username?></strong></p>
            <p class="lead"> Контакты: <span id="showPhone"> 8 <?= $model->user->phone ?></span> </p>

            <hr />
            <p><?=nl2br(Html::encode($model->body))?></p>
            <table class="table table-striped table-condensed">
                <?php
                foreach ($model->boardProperties as $property)
                {
                    if (!empty($property->value))
                    {
                        ?>
                        <tr>
                            <td><?=$property->property->name?></td>
                            <td><?=$property->value?></td>
                        </tr>
                        <?php
                    }

                }
                ?>
            </table>
        </div>
    </div>

</div>