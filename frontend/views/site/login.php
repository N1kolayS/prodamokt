<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добро пожаловать';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">

    <div class="row">
        <div class="col-md-12 text-center">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'horizontal']); ?>

            <?= $form->field($model, 'phone', [
            'inputTemplate' => '<div class="input-group"><span class="input-group-addon">8</span>{input}</div>',
            ])->widget(\yii\widgets\MaskedInput::className(), [
            'name' => 'phone',
            'mask' => '999-999-9999',

            ])->label() ?>

            <?= $form->field($model, 'password')->passwordInput()->label() ?>



            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
            </div>


            <div class="panel panel-body">
            <p class="text-muted">Если вы забыли пароль, то Вы можете его  <?= Html::a('сбросить здесь', ['site/request-password-reset']) ?>.</p>
            </div>
            <?php ActiveForm::end(); ?>
            <h3>Впервые на нашем сайте? <?=Html::a('Зарегистрируйтесь', ['site/signup'] )?>  Регистрация займет не более одной минуты</h3>
        </div>
        <div class="col-md-6">

        </div>


    </div>
</div>
