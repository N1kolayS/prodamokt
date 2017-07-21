<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Type;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Бесплатные Объявления. Продать, купить, авто, недвижимость, работа, товары - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <?php
    if (YII_ENV_PROD) {
        ?>
        <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45388365 = new Ya.Metrika({ id:45388365, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45388365" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    <?php
    }
    ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    \frontend\models\NavBarCustom::begin([
        'brandLabel' => '<img src="/images/logo.png" class="img-brand" alt="BoxOk" >  ',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default  navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '<span class="glyphicon glyphicon-bullhorn"></span> Подать объявление', 'url' => ['/board/step'], 'linkOptions' => ['class' => 'nav-add']  ],
        /*
        ['label' => 'Недвижимость', 'url' => ['/board/index', 'Search[common_id]' => Type::CATEGORY_PLACE ], 'linkOptions' => ['class' => 'nav-premises']  ],
        ['label' => 'Автомобили', 'url' => ['/board/index', 'Search[common_id]' => Type::CATEGORY_AUTO], 'linkOptions' => ['class' => 'nav-auto']  ],
        ['label' => 'Услуги', 'url' => ['/board/index', 'Search[common_id]' => Type::CATEGORY_SERVICE], 'linkOptions' => ['class' => 'nav-service'] ],
        ['label' => 'Работа', 'url' => ['/board/index', 'Search[common_id]' => Type::CATEGORY_JOB], 'linkOptions' => ['class' => 'nav-jobs'] ],
        ['label' => 'Электроника', 'url' => ['/board/index', 'Search[common_id]' => Type::CATEGORY_ELECT], 'linkOptions' => ['class' => 'nav-elect'] ],
        ['label' => 'Прочее', 'url' => ['/board/index', 'Search[common_id]' => Type::CATEGORY_STUFF], 'linkOptions' => ['class' => 'nav-stuff'] ],
*/

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
    \frontend\models\NavBarCustom::end();
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
        <div class="col-md-4">
            <p class="text-muted">&copy; BoxOK - коробка с объявлениями. <?= date('Y') ?></p>
        </div>
        <div class="col-md-6">
            <p class="text-muted"> По любым вопросам пишите нам на почту <?= Html::a('info@boxok.ru', 'mailto:info@boxok.ru')?></p>
        </div>
        <div class="col-md-2">
            <p class="pull-right">
                <?php
                if (YII_ENV_PROD)
                {
                ?>
                    <!-- Yandex.Metrika informer --> <a href="https://metrika.yandex.ru/stat/?id=45388365&amp;from=informer" target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/45388365/3_1_FFFFFFFF_EFEFEFFF_0_pageviews" style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="45388365" data-lang="ru" /></a> <!-- /Yandex.Metrika informer -->
            <?php
            }
            else
            {
                echo Html::img('http://fakeimg.pl/88x31/', ['style' => 'width:88px; height:31px; border:0;']);
            }
            ?>
            </p>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
