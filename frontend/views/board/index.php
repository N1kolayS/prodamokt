<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 06.03.17
 * Time: 23:46
 */

?>



<div class="col-md-1">

</div>
<div class="col-md-10">

    <?php
    // echo var_dump($models->getModels());

    echo \yii\widgets\ListView::widget([
        'pager' => [
            'firstPageLabel' => 'Первая',
            'lastPageLabel' => 'Последняя',
        ],
        'dataProvider' => $models,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
        ],

        'itemView' => '_record',
    ]);
    #*/
    ?>
</div>
<div class="col-md-1">

</div>
