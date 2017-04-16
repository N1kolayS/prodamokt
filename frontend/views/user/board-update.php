<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 29.03.17
 * Time: 1:14
 */


use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\Board */
/* @var $property_list array */

$title = 'Редактировать Объявление: '. $model->name;
$this->title = $title;

$this->params['breadcrumbs'][] = ['label' => 'Мой кабинет', 'url' => ['cabinet']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['board-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

$route_image_del = Url::toRoute(['ajax/image-delete', 'id' => $model->id]);
$route_image_add = Url::toRoute(['ajax/image-add', 'id' => $model->id]);
$script = <<< JS

function delImage(id_image)
{
    $.get( "$route_image_del", { id_image: id_image } )
            .done(function( json )
            {
                data = JSON.parse(json);
                if (data.success == true)
                {
                    $("#thumb_"+id_image).remove();
                }
            });
}
$('#file').change(function() {


    $("#wait_loading").show();
    $('#loading-btn').hide();

    var lengthFiles = this.files.length-1;
    console.log(lengthFiles);
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

                if (index == lengthFiles)
                {
                    $("#wait_loading").hide();
                    $('#loading-btn').show();
                }

                $("#img_list").append('<li  id="thumb_'+respond.image.id +'"><div class="thumbnail img-upload">'+
                                '<img src="'+respond.image.url +'" />' +
                                '<div class="caption"><a class="btn btn-danger btn-sm" role="button" onclick="delImage('+respond.image.id +')"><span class="glyphicon glyphicon-trash"></span> Удалить Изображение</a>'+
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

            foreach ($properties as $property)
            {

                ?>
                <div class="form-group">
                    <label class="control-label" for="property-<?= $property->number ?>"><?= $property->name ?></label>
                    <?= $property->generateMode->update($model->getValue($property->number)) ?>
                </div>
                <?php

            }


            ?>
        </div>
    </div>
    <hr />
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

                if ($model->existImages())
                {
                    foreach ($model->getImages() as $images)
                    {
                        ?>
                        <li  id="thumb_<?=$images->id?>">
                            <div class="thumbnail img-upload  ">
                                <?= Html::img($images->getUrl('150x150'))?>
                                <div class="caption">

                                    <a class="btn btn-danger btn-sm" role="button" onclick="delImage(<?=$images->id?>)"><span class="glyphicon glyphicon-trash"></span> Удалить Изображение</a>
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
                <?= Html::submitButton( 'Редактировать',  ['class' =>  'btn btn-success']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>