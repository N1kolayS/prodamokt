<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы объявлений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-index">

    <h1><?= Html::encode($this->title) ?></h1>
       <p>
        <?= Html::a('Создать тип', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'sort',
            [
                'attribute' => 'common_id',
                'format' => 'raw',
                'value' => function($data){
                    $mode = $data->ListCategory();
                    return $mode[$data->common_id];
                },
                'filter'=>$searchModel->ListCategory(),
            ],

            ['class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => '{view} {update} ',
            ],
        ],
    ]); ?>
</div>
