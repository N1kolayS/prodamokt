<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Region */

$this->title = 'Создать Регион';
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-create">

    <h1><?= Html::encode($this->title) ?></h1>
<p>Создать субъект РФ, например (Башкортостан, Оренбургская область)</p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
