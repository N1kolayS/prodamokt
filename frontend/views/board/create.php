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

            <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

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
                    <?= $property->generateCreate() ?>
                </div>
            <?php
                # */
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <?php

            echo $form->field($model, 'images[]')->widget(FileInput::classname(), [
                //'name' =>
                'language' => 'ru',
                'options'=>[
                    'multiple'=>true
                ],
                'pluginOptions' => [


                    'showPreview' => true,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,


                    'maxFileCount' => 5
                ]
            ])->label(false);
# */
            /*
            echo '<label class="control-label">Add Attachments</label>';
            echo FileInput::widget([
                'model' => $model,
                'attribute' => 'images[]',
                'options' => ['multiple' => true]
            ]);
            # */
            ?>

            <hr />


            <div class="form-group">
                <?= Html::submitButton( 'Создать',  ['class' =>  'btn btn-success']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>