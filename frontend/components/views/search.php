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
use common\models\Property;
$static_property = Property::MODE_RANGE;

$properties_route = Url::toRoute('ajax/get-properties');

$script = <<< JS
    var input_filed;
    var price_filed = $("#prices_field");
    var type_id = $("#search-type_id");
    function loadProp(id) {
        $("#search-price_min").val('');
        $("#search-price_max").val('');
        price_filed.hide();
        // Выбран общий тип или конкретная категория
        if (id.indexOf('common') >= 0)
        {
            //var common_id  = id.split('-')[1];
            $("#search-type_id").val('');
            $("#search-common_id").val(id.split('-')[1]);

        }
        else
        {
            $("#search-type_id").val(id);
            $("#search-common_id").val('');
            // Load Property
            $.get( "$properties_route", { id: id } )
            .done(function( json )
            {

                var result = JSON.parse(json);
                if (result.price != "")
                {
                    $( price_filed ).find( "label" ).html(result.price);
                    price_filed.show();
                }
                $.each(result.property, function() {
                    if (this.mode==" 1")
                    {

                    }
                });

            });
        }

    }

    $(document).ready(function() {

        if (type_id.val()!='')
        {
            loadProp(type_id.val());
        }



    });

JS;
$this->registerJs($script, yii\web\View::POS_END);
#*/
?>
<?php $form = ActiveForm::begin( [
    'action' => ['board/index'],
    'method' => 'GET',
    'options' => [
        'class' => 'form-inline main-search'
    ]
]); ?>
<?= Html::activeHiddenInput($model, 'common_id') ?>
<?= Html::activeHiddenInput($model, 'type_id') ?>
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h2 class="panel-title text-center">Поиск Объявлений</h2>
        </div>
        <div class="panel-body">

                <div class="col-md-3">
                    <?php
                    //echo var_dump(\common\models\Type::AllTypeSearch());
                    //Set Default
                    if ($model->common_id)
                    {
                        $default = 'common-'.$model->common_id;
                    }
                    else
                    {
                        $default = $model->type_id;
                    }

                    echo Html::dropDownList('name', $default, \common\models\Type::AllTypeSearch(),
                        [
                            'options' => \common\models\Type::AllTypeSearch(true),
                            'prompt' => '- Тип Объявления -',
                            'onchange'=>'loadProp($(this).val())',
                            'class' => 'form-control'
                        ]);

                    ?>
                    <div class="help-block"></div>
                </div>
                <div class="col-md-7">
                    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Я ищу...',  'class' => 'form-control main-search-input' ])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Найти!', ['class' => 'btn btn-primary', ]) ?>
                        <div class="help-block"></div>
                    </div>
                </div>


            <?php
             // echo $form->field($model, 'town_id')->dropDownList(\common\models\Town::OptAllTowns(), ['prompt' => '- Во всех городах -', ])->label(false);
             ?>


        </div>
        <div class="panel-footer">


        </div>
    </div>

<?php ActiveForm::end(); ?>
<?php
//echo var_dump($model->properties);
?>