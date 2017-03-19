<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */

$property_mode_route = Url::toRoute('ajax/property-mode');
$script_create = <<< JS

$(document).ready(function() {

    $("#property-value").prop('disabled', true);
});

JS;
$script = <<< JS



    function loadProp(id) {
            $("#property-value").val('');
             $.get( "$property_mode_route", { id: id } )
            .done(function( json )
            {

                data = JSON.parse(json);
                if (data.record)
                {
                    $("#property-value").prop('disabled', false);
                    $("#property-value").val(data.record);
                }
                else {

                    $("#property-value").prop('disabled', true);
                }

            });

    }

JS;
$this->registerJs($script, yii\web\View::POS_END);

if ($model->isNewRecord)
{
    $this->registerJs($script_create, yii\web\View::POS_END);
}
?>

<div class="property-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'type_id')->dropDownList(\common\models\Type::AllTypes(),  ['prompt'=>'-Выберите Тип-']) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sort')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'mode')->dropDownList($model::ListMode(), ['prompt' => '- Режим значения -',  'onchange'=>'loadProp($(this).val())']) ?>

            <?= $form->field($model, 'modelName')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'value')->textInput() ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
