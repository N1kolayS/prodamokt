<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Town */

$this->title = 'Создать Город';
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="town-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
