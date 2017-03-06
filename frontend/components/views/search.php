<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 06.03.17
 * Time: 23:37
 */


/* @var $model frontend\models\Search */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/*
 * OLD Data
$getpropeties_route = Url::toRoute('ajax/getpropeties');
$script = <<< JS
    var input_filed;
    function loadProp(id) {
        id_obj = $("#search-id_object").val();
        id_type = $("#search-id_type").val();
        if ((id_obj!='')&&(id_type!=''))
        {
        $("#LoadAjax").empty();
             $.get( "$getpropeties_route", { id_object: id_obj, id_type: id_type } )
            .done(function( json )
            {
                data = JSON.parse(json);
                $.each(data, function() {
                    if (this.val != false)
                    {
                        input_filed = '<select class="form-control" name="Search[properties]['+ this.id +']"><option value=""> - '+this.name+' - </option>';
                        $.each(this.val, function(){
                            input_filed = input_filed + '<option value="'+ this +'">'+this+'</option>';
                        });
                        input_filed = input_filed + '</select>';
                        $("#LoadAjax").append(input_filed);
                    }
                });
            });
        }
        else {
            $("#LoadAjax").empty();
        }
    }

JS;
$this->registerJs($script, yii\web\View::POS_HEAD);
*/
?>
<?php $form = ActiveForm::begin( [
    'action' => ['board/index'],
    'method' => 'GET',
    'options' => [
        'class' => 'form-inline main-search'
    ]
]); ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title text-center">Поиск Недвижимости</h2>
        </div>
        <div class="panel-body">

            <?= $form->field($model, 'id_type')->dropDownList(\common\models\Type::AllTypes(), ['prompt' => '- Тип Объявления -',  'onchange'=>'loadProp($(this).val())'])->label(false) ?>

            <?= $form->field($model, 'name')->textInput(['placeholder' => 'Я ищу...'])->label(false) ?>
            <?= $form->field($model, 'id_town')->dropDownList(\common\models\Town::OptAllTowns(), ['prompt' => '- Во всех городах -', ])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Найти!', ['class' => 'btn btn-primary', ]) ?>
                <div class="help-block"></div>
            </div>

        </div>
        <div class="panel-footer">
            <div class="row">


            </div>

        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
//echo var_dump($model->properties);
?>