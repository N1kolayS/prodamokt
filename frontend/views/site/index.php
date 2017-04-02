<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use common\models\Type;

/* @var $this yii\web\View */


$script = <<< JS


    $(document).ready(function() {
        var min =1;
        var max =2;
        var random =  min + Math.floor(Math.random() * (max + 1 - min));

        if (random==1)
        {
            $("#promo_1").show();
        }
        else
        {
            $("#promo_2").show();
        }



    });

JS;
$this->registerJs($script, yii\web\View::POS_END);
?>
<div class="site-index">


    <div class="row">
        
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4 ">
                    <div class="main-pin  text-center">
                        <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_PLACE  ]) ?>">
                            <img src="/images/pin-premises.png" height="150" width="auto"  >
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
                <div class="col-md-4">
                    <div class="main-pin  text-center">
                        <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_AUTO ]) ?>">
                            <img src="/images/pin-auto.png"  height="150" width="auto" >
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
                <div class="col-md-4">
                    <div class="main-pin  text-center">
                        <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_SERVICE  ]) ?>">
                            <img src="/images/pin-service.png"  height="150" width="auto" >
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
            </div>

            <div class="row">
                <div class="col-md-4 ">
                    <div class="main-pin text-center">
                        <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_JOB  ]) ?>">
                            <img src="/images/pin-jobs.png" height="150" width="auto"  >
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

                <div class="col-md-4">
                    <div class="main-pin text-center">
                        <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_ELECT  ]) ?>">
                            <img src="/images/pin-elect.png" height="150" width="auto"  >
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
                <div class="col-md-4">
                    <div class="main-pin text-center">
                        <a href="<?= Url::toRoute(['board/index', 'Search[common_id]' => Type::CATEGORY_STUFF  ]) ?>">
                            <img src="/images/pin-things.png" height="150" width="auto"  >
                        </a>
                        <h1 class="main-pin-text">Личные вещи</h1>
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
        </div>
        <div class="col-md-3">
           <div id="promo_1" style="display: none"><?= Html::a('<img src="/promo/sultan.gif" alt="Баня султан" height="400" width="240" class="img-responsive">', 'https://vk.com/territoriyavkusa', ['target' => '_blank'] ) ?></div>
           <div id="promo_2" style="display: none"> <?= Html::a('<img src="/promo/autokruiz.jpg" alt="Уфа-Казань" height="400" width="240" class="img-responsive">', 'https://vk.com/territoriyavkusa', ['target' => '_blank'] ) ?></div>
        </div>



    </div>



</div>
