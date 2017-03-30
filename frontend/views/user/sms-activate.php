<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 21.03.17
 * Time: 23:27
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\SmsActivateForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Активация';
$this->params['breadcrumbs'][] = ['label' => 'Мой кабинет', 'url' => ['cabinet']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-sms-activate">
    <div class="row">
        <div class="col-md-12 text-center">
            <h3 class="text-center">Поздравляем, уже сейчас вы можете подавать объявления</h3>
            <p class="lead">На ваш номер отправлен СМС с кодом. Пожалуйста укажите его, для завершения регистрации.  </p>

            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <?= $form->field($model, 'sms_code')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
