<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$activate_user_route = Url::toRoute('ajax/user-activation');
$reset_user_route = Url::toRoute('ajax/user-password-reset');
$user_id = $model->id;
$model->isActivate() ? $status_activate=1 : $status_activate=0;


$script = <<< JS

var status_activate = $status_activate;
var user_id = $user_id;

$(document).ready(function() {
    if (status_activate==1)
    {
        $('#activation').hide();
    }
    else
    {
        $('#activate').hide();
    }

    $('#activation').click(function() {
    $.get( "$activate_user_route", { id: user_id } )
            .done(function( json )
            {
            data = JSON.parse(json)
            console.log(data);
                if (data.status == 0)
                {
                   $('#activation').hide();
                   $('#activate').show();

                }

            });
    });


    $('#password_reset').click(function() {
    $.get( "$reset_user_route", { id: user_id } )
            .done(function( json )
            {
            data = JSON.parse(json)

                if (data.status == 0)
                {
                   $('#password_reset').hide();
                   $('#password_success').show();

                }

            });
    });
});


JS;
$this->registerJs($script, yii\web\View::POS_END);

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-right">
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'created_at:datetime',
                    'updated_at:datetime',
                    'username',
                    'email:email',
                    'phone',

                ],
            ]) ?>
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <td><strong>Статус</strong></td>
                    <td><?=$model::listStatus()[$model->status] ?></td>
                </tr>
                <tr>
                    <td><strong>Активация</strong></td>
                    <td><span class="label label-success" id="activate">Активирован</span> <a id="activation" class="btn btn-success btn-sm"> Активировать <span class="label label-warning">Код <?=$model->sms_code_activate ?></span> </a> </td>
                </tr>
                <tr>
                    <td><strong>Роль</strong></td>
                    <td><?=$model->allRoles[$model->role] ?></td>
                </tr>
                <tr>
                    <td><strong>Сброосить пароль</strong></td>
                    <td> <a id="password_reset" class="btn btn-default btn-sm">Установить пароль: <strong><?=$model->phone ?></strong> </a> <span class="label label-success" style="display: none" id="password_success">Пароль сброшен на <?=$model->phone ?></span> </td>
                </tr>
            </table>

        </div>
        <div class="col-md-6">
            <?php
            if ($model->boards==null)
            {
                echo '<h3>Объявлений нет</h3>';
            }
            else
            {

                echo '<ul class="list-group">';
                foreach ($model->boards as $board)
                {
                    echo Html::tag('li', Html::a($board->name, ['board/view', 'id' => $board->id]), ['class' => 'list-group-item']);
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>


</div>
