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


$properties_route = Url::toRoute('ajax/get-properties');

$script = <<< JS
    var input_filed;
    var price_filed = $("#prices_field");
    var type_id = $("#search-type_id");
    var prop_field = $("#prop");
    var prop_listing = $("#prop_listing");

    function loadProp(id) {
        $("#search-price_min").val('');
        $("#search-price_max").val('');
        prop_field.hide();
        prop_listing.empty();
        // Выбран общий тип или конкретная категория
        if (id.indexOf('common') >= 0)
        {

            $("#search-type_id").val('');
            $("#search-common_id").val(id.split('-')[1]);

        }
        else
        {
            $("#search-type_id").val(id);
            $("#search-common_id").val('');
            // Load Property
            /*
            $.get( "$properties_route", { id: id } )
            .done(function( json )
            {

                var result = JSON.parse(json);
                if (result.property.length != 0)
                {
                    prop_field.show();
                    if (result.price != "")
                    {
                        $( price_filed ).find( "label" ).html(result.price);

                    }
                    $.each(result.property, function() {

                        if (this.val.type == 'list')
                        {
                            html_append = '<select class="form-control" name=Search[property]['+ this.val.id +']>';
                            html_append += '<option value="">'+this.val.prompt +'</option>';
                            $.each(this.val.list, function() {
                                if (get_property[this.val.id]==this)
                                {
                                    html_append += '<option selected value="'+this +'">'+this +'</option>';
                                }
                                else
                                {
                                    html_append += '<option value="'+this +'">'+this +'</option>';
                                }


                            });
                            html_append += '</select>';
                        }
                        prop_listing.append(html_append+' &nbsp;&nbsp; ');
                    });

                }

            });
            */
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
//echo var_dump($model->property);
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
            <div class="row" id="prop" style="display: none">

                <div class="col-md-8" id="prop_listing">

                </div>
                <div class="col-md-4">
                    <div class="text-right" id="prices_field">
                        <label>Цена</label>
                        <?= $form->field($model, 'price_min')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                'alias' =>  'decimal',
                                'groupSeparator' => ' ',
                                'autoGroup' => true,
                            ],
                        ])->label(false) ?> -
                        <?= $form->field($model, 'price_max')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                'alias' =>  'decimal',
                                'groupSeparator' => ' ',
                                'autoGroup' => true,
                            ],
                        ])->label(false) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php ActiveForm::end(); ?>
<?php
//echo var_dump($model->properties);
?>