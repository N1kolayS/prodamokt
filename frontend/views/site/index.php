<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use common\models\Type;

/* @var $this yii\web\View */


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
            <img src="http://fakeimg.pl/240x400/?text=Reklama&font=lobster">
        </div>



    </div>



</div>
