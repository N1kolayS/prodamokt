<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Объявления Октябрьский Туймазы. Продать, купить, авто, недвижимость, работа, товары - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/images/logo.png" >',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-top  navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Подать объявление', 'url' => ['/board/step'], 'linkOptions' => ['class' => 'nav-add']  ],
        ['label' => 'Недвижимость', 'url' => ['/board/index'], 'linkOptions' => ['class' => 'nav-premises']  ],
        ['label' => 'Автомобили', 'url' => ['/board/index'], 'linkOptions' => ['class' => 'nav-auto']  ],
        ['label' => 'Работа', 'url' => ['/board/index'], 'linkOptions' => ['class' => 'nav-jobs'] ],
        ['label' => 'Электроника', 'url' => ['/board/index'], 'linkOptions' => ['class' => 'nav-stuff'] ],
        ['label' => 'Услуги', 'url' => ['/board/index'], 'linkOptions' => ['class' => 'nav-stuff'] ],

    ];
    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {

        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-user"></span> '.Yii::$app->user->identity->username,  'items' =>
            [
                ['label' => 'Мой кабинет ', 'url' => ['/user/cabinet']],
//                ['label' => 'Мои объявления', 'url' => ['/user/my']],
                ['label' => 'Выйти ', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
            ]

        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ПродамОкт <?= date('Y') ?></p>


    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
