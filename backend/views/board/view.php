<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Board */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-right">
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить безвозвратно?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
        //    'user.fio',
            'type.name',
            'town.name',
            'created_at:datetime',
            'started_at:datetime',
            'finished_at:datetime',
            'updated_at:datetime',

            'name',
            'body:ntext',
            'cost',
            'views',
            'looks',
            'enable',

        ],
    ]) ?>

    <?=$model->isStarted()?>


</div>
