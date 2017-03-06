<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Property */

$this->title = 'Изменить свойство: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Свйоства', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="property-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
