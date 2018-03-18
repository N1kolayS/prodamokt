<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use common\models\Type;

/* @var $this yii\web\View */


$this->title = 'Бесплатные Объявления. Продать, купить, авто, недвижимость, работа, товары';
$this->registerMetaTag(['property' => 'og:image' , 'content' =>Url::to(['images/vk-ot.png'], true)]);
$this->registerMetaTag(['property' => 'vk:image' , 'content' =>Url::to(['images/vk-ot.png'], true)]);

?>


<div class="site-index">
    <h2 class="text-center main-head"> BoxOK - Сайт бесплатных объявлений </h2>
    <p class="text-center list-town ">
        <?php
        $isLine = false;
        foreach ($towns as $twn)
        {
            echo $isLine? ' | ' : ' ';
            $isLine = true;
            echo   Html::a($twn->name, ['board/index', 'Search[town_id]' => $twn->id ]);
        }

        ?>
    </p>
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
                <h1 class="main-pin-text">Транспорт</h1>
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
    <div class="text-center">
        <p class="main-pin-text">Подписывайтесь: <a href="<?=Yii::$app->params['social.vk']?>"> <img src="/images/vk.png" height="30" width="auto"></a></p>
    </div>
</div>
