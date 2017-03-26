<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 19.02.17
 * Time: 15:13
 */

/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\helpers\Html;

$this->title = 'Мой кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-cabinet">
    <h2>Здравствуйте, <?= $model->username ?></h2>

    <div class="row">
        <div class="col-md-8">
            <?php
            echo \yii\widgets\ListView::widget([
                'pager' => [
                    'firstPageLabel' => 'Первая',
                    'lastPageLabel' => 'Последняя',
                ],
                'dataProvider' => $providerBoards,
                'options' => [
                    'tag' => 'div',
                    'class' => 'list-wrapper',
                    'id' => 'list-wrapper',
                ],
                'emptyText' => 'Объявлений не найдено',
                'summary' =>'<span class="text-muted">Объявления с {begin} по {end}. Всего {totalCount} </span> ',

                'itemView' => '_record',
            ]);
            ?>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                <h2 class="panel-title text-center">Мои данные </h2>
                </div>
                <div class="panel-body">
                    <p>Имя: <strong><?=$model->username?></strong></p>
                    <p>Телефон: <strong>8<?=$model->phone?></strong> <?php if ($model->isActivate()) { ?> <span class="label label-success">Подтвержден</span> <?php } else {  ?> <span class="label label-warning">не подтвержден</span>  <?php echo Html::a('Подтвердить', ['sms-activate']);  } ?></p>
                   <!-- <p>Email: <strong><?=$model->email?></strong></p> -->
                </div>
                <div class="panel-footer">
                    <?= Html::a('Изменить данные', ['update'], ['class' => 'btn btn-default'])?> <?= Html::a('Изменить пароль', ['change-password'], ['class' => 'btn btn-default'])?>
                </div>
            </div>
        </div>
    </div>

</div>
