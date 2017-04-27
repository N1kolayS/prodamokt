<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 06.03.17
 * Time: 23:46
 */

?>

<div class="row">
    <div class="col-md-12">
        <?php
        // Вывод виджета поиска
        echo \app\components\SearchWidget::widget([
            'model' => $model,
        ]);
        ?>
    </div>
</div>

<div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-10">

    <?= \yii\widgets\ListView::widget([
            'pager' => [
                'firstPageLabel' => 'Первая',
                'lastPageLabel' => 'Последняя',
            ],
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
                'emptyText' => 'Объявлений не найдено',
                'summary' =>'<span class="text-muted">Объявления с {begin} по {end}. Всего {totalCount} </span> ',

            'itemView' => '_record',
        ]); ?>

    </div>
    <div class="col-md-1">

    </div>
</div>


