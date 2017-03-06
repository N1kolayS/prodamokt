<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Type */

$this->title = 'Создать Тип';
$this->params['breadcrumbs'][] = ['label' => 'Типы объявлений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
