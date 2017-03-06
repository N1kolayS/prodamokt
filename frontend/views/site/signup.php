<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("jQuery('#reveal-password').hover(
  function() {
    jQuery('#signupform-password').attr('type','text');
  }, function() {
    jQuery('#signupform-password').attr('type','password');
  }
)", $this::POS_END);
?>
<div class="site-signup">


    <div class="row">
        <div class="col-md-12 text-center">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Укажите Ваше имя, свой телефон, и пароль</p>
        </div>
        <div class="col-md-12 text-center">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'layout' => 'horizontal']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'phone', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon">8</span>{input}</div>',
            ])->widget(\yii\widgets\MaskedInput::className(), [
                'name' => 'phone',
                'mask' => '999-999-9999',

            ])->label() ?>


                <?= $form->field($model, 'password',[
                'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon"><span class="glyphicon glyphicon-eye-open" id="reveal-password"></span> </span></div>',
            ])->passwordInput() ?>


                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
