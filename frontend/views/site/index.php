<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */


?>
<div class="site-index">


    <div class="row">
        
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="pin-premises pull-right">
                        <a href="#">
                            <img src="/images/pin-premises.png" height="180" width="auto"  >
                        </a>
                        <h1 class="main-pin-text">Недвижимость</h1>
                        <p class="text-justify"><?=Html::a('Квартиры', ['board/index'])?> &nbsp;&nbsp;&nbsp;&nbsp; <?=Html::a('Дома', ['board/index'])?> &nbsp;&nbsp;&nbsp;&nbsp; <?=Html::a('Участки', ['board/index'])?> </p>
                        <p class="text-justify"><?=Html::a('Коммерческая', ['board/index'])?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=Html::a('Гаражи', ['board/index'])?> </p>
                    </div>

                </div>
                <div class="col-md-6 text-center">
                    <div class="pin-auto">
                        <a href="#">
                            <img src="/images/pin-auto.png"  height="180" width="auto" >
                        </a>
                        <h1 class="main-pin-text">Автомобили</h1>
                        <p class="text-justify">&nbsp;&nbsp;&nbsp; <?=Html::a('Легковые', ['board/index'])?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=Html::a('Мототехника', ['board/index'])?>  </p>
                        <p class="text-justify">&nbsp;&nbsp;&nbsp; <?=Html::a('Коммерческие', ['board/index'])?> &nbsp;&nbsp;&nbsp; <?=Html::a('Грузовые', ['board/index'])?>  </p>
                    </div>

                </div>

                <div class="col-md-6 ">
                    <div class="pin-jobs pull-right">
                        <a href="#">
                            <img src="/images/pin-jobs.png" height="180" width="auto"  >
                        </a>
                        <h1 class="main-pin-text">Работа, Услуги</h1>
                        <p class="text-justify"> <?=Html::a('Вакансии', ['board/index'])?>&nbsp;&nbsp;   <?=Html::a('Резюме', ['board/index'])?>&nbsp;&nbsp;     <?=Html::a('Услуги', ['board/index'])?> </p>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="pin-things">
                        <a href="#">
                            <img src="/images/pin-things.png" height="180" width="auto"  >
                        </a>
                        <h1 class="main-pin-text">Электроника</h1>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <img src="http://fakeimg.pl/350x700/?text=Reklama&font=lobster">
        </div>



    </div>


</div>
