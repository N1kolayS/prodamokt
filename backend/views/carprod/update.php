<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Carprod */

$this->title = 'Изменить автопроизводителя: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Автопроизводители', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="carprod-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
