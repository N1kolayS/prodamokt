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
$this->params['breadcrumbs'][] = ['label' => 'Мой кабинет', 'url' => ['cabinet']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-change-password">

    <div class="row">
        <div class="col-md-12 text-center">
            <h3><?= $this->title ?></h3>
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <?= $form->field($model, 'password')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'new_password')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
