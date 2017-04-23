<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 23.04.17
 * Time: 23:23
 */

namespace frontend\models;


use yii\bootstrap\Html;
use yii\bootstrap\NavBar;

class NavBarCustom extends NavBar
{
    /**
     * Renders collapsible toggle button.
     * @return string the rendering toggle button.
     */
    protected function renderToggleButton()
    {
        $bar = Html::tag('span', 'МЕНЮ');
        $screenReader = "<span class=\"sr-only\">{$this->screenReaderToggleText}</span>";

        return Html::button("{$screenReader}\n{$bar}", [
            'class' => 'navbar-toggle',
            'data-toggle' => 'collapse',
            'data-target' => "#{$this->containerOptions['id']}",
        ]);
    }
}