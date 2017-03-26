<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model){
            if ($model->status == $model::STATUS_DELETED) {
                return ['class' => 'danger'];
            }
            else {
                if ($model->isActivate())
                    return ['class' => ''];
                else
                    return ['class' => 'info'];
            }
        },
        'columns' => [

            'id',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d M Y H:i']
            ],
            'username',

            // 'email:email',
             'phone',
            [
                'attribute' => 'role',
                'format' => 'raw',
                'value' => function($data){
                    return $data->allRoles[$data->role];
                },
                'filter'=>$searchModel->AllRoleGrid(),
            ],
            // 'role',
            // 'status',

            ['class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '40'],
                'template' => '{view}  ',
            ],
        ],
    ]); ?>
</div>
