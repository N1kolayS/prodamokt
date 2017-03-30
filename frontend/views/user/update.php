<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 22.03.17
 * Time: 23:45
 */


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменить';
$this->params['breadcrumbs'][] = ['label' => 'Мой кабинет', 'url' => ['cabinet']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-update">

    <div class="row">
        <div class="col-md-12 text-center">
            <h3><?= Html::encode($this->title) ?></h3>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'horizontal', 'enableClientScript' => false]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'phone', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon">8</span>{input}</div>',
            ])->widget(\yii\widgets\MaskedInput::className(), [
                'name' => 'phone',
                'mask' => '999-999-9999',

            ])->label() ?>


            <div class="form-group">
                <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>


            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>
