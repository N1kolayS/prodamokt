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


$route_image_del    = Url::toRoute(['ajax/image-create-delete']);
$route_image_add    = Url::toRoute(['ajax/image-create-add']);
$route_image_rotate = Url::toRoute(['ajax/image-create-rotate']);
$script = <<< JS

$(function(){
     $(".btn-success").click(function () {
       $(".btn-success").attr("disabled", true);
       $(".btn-success").html('Подготовка к публикации');
       $('#w0').submit();
      $('input, textarea, select').click(function(){
        $(".btn-success").attr("disabled", false);
        $(".btn-success").html('Создать');
      })

     });
   });

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

function rotateImage(name, id_index)
{
    $.get( "$route_image_rotate", { name: name } )
            .done(function( json )
            {
                data = JSON.parse(json);
                if (data.success == true)
                {
                    img = $("#thumb_"+id_index).find('img');
                    date = new Date();
                    newsrc = img.attr('src')+'?'+date.getTime();
                    img.attr('src', newsrc);

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
                                '<div class="img-upload-over"><img src="'+respond.image.url +'" height="auto" width="200" /></div>' +
                                '<div class="caption">' +
                                '<a class="btn btn-danger btn-sm" role="button" onclick="delImage(\''+respond.image.name +'\', '+id_i+')"><span class="glyphicon glyphicon-trash"></span> Удалить </a> ' +
                                ' <a class="btn btn-info btn-sm" role="button" onclick="rotateImage(\''+respond.image.name +'\', '+id_i+')"><span class="glyphicon glyphicon-repeat"></span> Повернуть</a>'+
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

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <?php
            if ($model->type->cost_name)
            {
                echo $form->field($model, 'cost')->widget(\yii\widgets\MaskedInput::className(), [
                    'clientOptions' => [
                        'alias' =>  'decimal',
                        'groupSeparator' => ' ',
                        'autoGroup' => true,
                    ],
                ])->label($model->type->cost_name);
            }
            ?>


        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'town_id')->dropDownList(\common\models\Town::OptAllTowns(), ['prompt' => '- Выберите город -']) ?>
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
                    <span class="glyphicon glyphicon-picture"></span> Добавить фото <?= Html::input('file', 'images[]', null, ['multiple' => true , 'id' => 'file', 'accept'=> 'image/*'])?>
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
                                <div class="img-upload-over">
                                    <img src="<?=$scan_dir['url'].$images?>" width="200" height="auto" />
                                </div>

                                <div class="caption">

                                    <a class="btn btn-danger btn-sm" role="button" onclick="delImage('<?=$images?>', 99999<?=$i?>)"><span class="glyphicon glyphicon-trash"></span> Удалить</a>
                                    <a class="btn btn-info btn-sm" role="button" onclick="rotateImage('<?=$images?>', 99999<?=$i?>)"><span class="glyphicon glyphicon-repeat"></span> Повернуть</a>
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