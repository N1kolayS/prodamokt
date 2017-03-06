<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TownSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="town-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a('Создать Город', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'region',
                'value' => 'region.name',
                'filter'=>$searchModel->getAllRegionGrid(),
            ],
            'name',
            'full_name',
            'default',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
