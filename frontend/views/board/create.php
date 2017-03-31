<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 02.03.17
 * Time: 16:43
 */


use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Board */
/* @var $property common\models\Property */
/* @var $model_type common\models\Type */
/* @var $property_list array */

$title = 'Создать Объявление: '. $model_type->common.' - '. $model_type->name;
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;


$route_image_del = Url::toRoute(['ajax/image-create-delete']);
$route_image_add = Url::toRoute(['ajax/image-create-add']);
$script = <<< JS

var id_i = 0;
function delImage(name, id_index)
{
    $.get( "$route_image_del", { name: name } )
            .done(function( json )
            {
                data = JSON.parse(json);
                if (data.success == true)
                {
                    $("#thumb_"+id_index).remove();
                }
            });
}
$('#file').change(function() {

    $("#wait_loading").show();
    $('#loading-btn').hide();

    var lengthFiles = this.files.length-1;
    jQuery.each(this.files, function(index, value) {
        //btn.addClass('disabled');

        var data = new FormData();
        data.append(0, value);

         $.ajax({
        type: 'POST',
        data: data,
        url: "$route_image_add",
        cache: false,
        contentType: false,
        processData: false,
        success: function(value){
            respond = JSON.parse(value);
            if (respond.success)
            {
                id_i++;
                if (index == lengthFiles)
                {
                    $("#wait_loading").hide();
                    $('#loading-btn').show();
                }
                $("#img_list").append('<li  id="thumb_'+id_i +'"><div class="thumbnail img-upload">'+
                                '<img src="'+respond.image.url +'" height="150" class="img-responsive" />' +
                                '<div class="caption"><a class="btn btn-danger btn-sm" role="button" onclick="delImage(\''+respond.image.name +'\', '+id_i+')"><span class="glyphicon glyphicon-trash"></span> Удалить Изображение</a>'+
                                '</div></div></li>');
            }
        }
    });

    data = null;

    });

$('#file').val('');


});



JS;
$this->registerJs($script, yii\web\View::POS_END);


?>
<div class="type-create">

    <h3><?= Html::encode($this->title) ?> </h3>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'type_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'town_id')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <?php
            if ($model->type->cost_name)
            {
                echo $form->field($model, 'cost')->textInput(['maxlength' => true])->label($model->type->cost_name);
            }
            ?>

            <?php
            //$form->field($model, 'town_id')->dropDownList(\common\models\Town::OptAllTowns(), ['prompt' => '- Выберите город -'])
            ?>
        </div>
        <div class="col-md-6">
            <?php
            foreach ($property_list as $property)
            {
                #echo var_dump($property);
               # /*
                ?>
                <div class="form-group">
                    <label class="control-label" for="property-<?= $property->id ?>"><?= $property->name ?></label>
                    <?= $property->generateMode->create() ?>
                </div>
            <?php
                # */
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="thumbnail">
                <label class="btn btn-info btn-file" id="loading-btn" data-loading-text="Пожалуйста подождите. Идет Загрузка фото ...">
                    <span class="glyphicon glyphicon-picture"></span> Добавить фото <?= Html::input('file', 'images[]', null, ['multiple' => true , 'id' => 'file'])?>
                </label>
                <span class="label label-warning" style="display: none" id="wait_loading">Пожалуйста ожидайте, идет загрузка файлов.</span>

            </div>

            <ul class="list-inline" id="img_list">
                <?php
                $scan_dir = \common\models\Board::scanDirImages();
                if ($scan_dir)
                {
                    $i = 0;
                    foreach ($scan_dir['files'] as $images)
                    {
                        $i++;
                        ?>
                        <li  id="thumb_99999<?=$i?>">
                            <div class="thumbnail img-upload  ">
                                <img src="<?=$scan_dir['url'].$images?>" width="150" height="auto" />
                                <div class="caption">

                                    <a class="btn btn-danger btn-sm" role="button" onclick="delImage('<?=$images?>', 99999<?=$i?>)"><span class="glyphicon glyphicon-trash"></span> Удалить Изображение</a>
                                </div>
                            </div>
                        </li>
                        <?php

                    }
                }

                ?>

            </ul>
            <hr />


            <div class="form-group">
                <?= Html::submitButton( 'Создать',  ['class' =>  'btn btn-success']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>