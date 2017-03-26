<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 26.03.17
 * Time: 11:17
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\SmsActivateForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменить пароль';
$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => ['cabinet']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-cabinet">
    <h2>Здравствуйте, <?= $model->user->username ?></h2>

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'new_password')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
