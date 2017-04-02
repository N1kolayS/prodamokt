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
?>
<div class="board-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <?php
            $image = $model->getImage();;
            if ($image)
            {
                echo Html::img($image->getUrl('400x'));
            }

            ?>
        </div>

        <div class="col-md-6">
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