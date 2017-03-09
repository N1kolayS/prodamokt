<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 06.03.17
 * Time: 23:46
 */

?>


<div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-10">
        <?php
        // Вывод виджета поиска
            echo \app\components\SearchWidget::widget([
                'model' => $model,

            ]);

        ?>

        <?php
            echo \yii\widgets\ListView::widget([
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

            'itemView' => '_record',
        ]);
            ?>
    </div>
    <div class="col-md-1">

    </div>
</div>

<div class="row">
    <div class="col-md-1">
        &nbsp;
    </div>
    <div class="col-md-10">
        <img src="http://fakeimg.pl/950x100/?text=Reklama&font=lobster">
    </div>
</div>
