<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 19.02.17
 * Time: 15:13
 */

/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\helpers\Html;

$this->title = 'Мой кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-cabinet">
    <h1>Здравствуйте, <?= $model->username ?></h1>


</div>
