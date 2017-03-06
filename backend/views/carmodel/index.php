<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CarmodelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модели';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carmodel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать модель', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'carprod',
                'value' => 'carprod.name',
                'filter'=>$searchModel->AllCarprodGrid(),
            ],
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
