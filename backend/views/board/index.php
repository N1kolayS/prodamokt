<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объявления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-index">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d M Y H:i']
            ],
            [
                'attribute' => 'type',
                'value' => 'type.name',
                'filter'=>$searchModel->getAllTypeGrid(),
            ],
            [
                'attribute' => 'town',
                'value' => 'town.name',
                'filter'=>$searchModel->getAllTownGrid(),
            ],
            [
                'attribute' => 'user',
                'format' => 'raw',
                'value' => function($model, $data){
                    return Html::a($model->user->username, ['user/view', 'id' => $model->user_id]);
                },
            ],

            // 'updated_at',
             'name',
            // 'body:ntext',
             'cost',
             'views',
             'looks',
            // 'enable',
            // 'marked',

            ['class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => '{view} ',
            ],
        ],
    ]); ?>
</div>
