<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Carprod */

$this->title = 'Создать Автопроизводителя';
$this->params['breadcrumbs'][] = ['label' => 'Автопроизводитель', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carprod-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
