<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Carmodel */

$this->title = 'Создать Модель';
$this->params['breadcrumbs'][] = ['label' => 'Модели', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carmodel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
