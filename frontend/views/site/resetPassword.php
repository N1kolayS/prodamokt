<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сбросить пароль';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("jQuery('#reveal-password').hover(
  function() {
    jQuery('#resetpasswordform-new_pass').attr('type','text');
  }, function() {
    jQuery('#resetpasswordform-new_pass').attr('type','password');
  }
)", $this::POS_END);
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Укажите ваш новый пароль и код из СМС:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
            <?= $form->field($model, 'sms_token')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'new_pass',[
                'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon"><span class="glyphicon glyphicon-eye-open" id="reveal-password"></span> </span></div>',
            ])->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Установить новый пароль', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
