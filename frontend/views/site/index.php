<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use common\models\Type;

/* @var $this yii\web\View */


$script = <<< JS



JS;
//$this->registerJs($script, yii\web\View::POS_END);
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-2 ">
            <div class="main-pin  text-center">
                <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_PLACE  ]) ?>">
                    <img src="/images/pin-premises.png" height="140" width="auto" class="pin-image"  >
                </a>
                <h1 class="main-pin-text">Недвижимость</h1>
                <div class="main-pin-list text-justify">
                    <?php
                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_PLACE)
                        {
                            echo Html::a($type->name, ['board/index', 'Search[type_id]' => $type->id]). ' ';
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
        <div class="col-md-2">
            <div class="main-pin  text-center">
                <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_AUTO ]) ?>">
                    <img src="/images/pin-auto.png"  height="140" width="auto" class="pin-image" >
                </a>
                <h1 class="main-pin-text">Автомобили</h1>
                <div class="main-pin-list text-justify">
                    <?php
                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_AUTO)
                        {
                            echo Html::a($type->name, ['board/index', 'Search[type_id]' => $type->id]). ' ';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="main-pin  text-center">
                <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_SERVICE  ]) ?>">
                    <img src="/images/pin-service.png"  height="140" width="auto" class="pin-image" >
                </a>
                <h1 class="main-pin-text">Услуги</h1>
                <div class="main-pin-list text-justify">
                    <?php
                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_SERVICE)
                        {
                            echo Html::a($type->name, ['board/index', 'Search[type_id]' => $type->id]). ' ';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-2 ">
            <div class="main-pin text-center">
                <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_JOB  ]) ?>">
                    <img src="/images/pin-jobs.png" height="140" width="auto" class="pin-image" >
                </a>
                <h1 class="main-pin-text">Работа</h1>
                <div class="main-pin-list text-justify">
                    <?php
                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_JOB)
                        {
                            echo Html::a($type->name, ['board/index', 'Search[type_id]' => $type->id]). ' ';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="main-pin text-center">
                <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_ELECT  ]) ?>">
                    <img src="/images/pin-elect.png" height="140" width="auto" class="pin-image" >
                </a>
                <h1 class="main-pin-text">Электроника</h1>
                <div class="main-pin-list text-justify">
                    <?php
                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_ELECT)
                        {
                            echo Html::a($type->name, ['board/index', 'Search[type_id]' => $type->id]). ' ';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="main-pin text-center">
                <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_STUFF  ]) ?>">
                    <img src="/images/pin-things.png" height="140" width="auto"  class="pin-image" >
                </a>
                <h1 class="main-pin-text">Разное</h1>
                <div class="main-pin-list text-justify">
                    <?php
                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_STUFF)
                        {
                            echo Html::a($type->name, ['board/index', 'Search[type_id]' => $type->id]). ' ';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <h1 class="text-center main-pin-text">Недавно опубликованные объявления</h1>
            <?php
            foreach ($board_last as $model)
            {
                echo $this->render('../board/_record', [
                    'model' => $model,
                ]);
            }
            ?>
        </div>
        <div class="col-md-2">

        </div>

    </div>
</div>
