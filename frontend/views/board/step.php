<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 02.03.17
 * Time: 15:58
 */

/* @var $list_types  */
/* @var $list_category  */
/* @var $type common\models\Type */


use yii\helpers\Html;
use \common\models\Type;

$this->title = 'Выберите тип объявления';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="board-step">
    <?=Html::beginForm(['board/create', 'post'])?>

    <div class="row">
        <div class="col-md-4">
            <div>
                <h2><?=$list_category[Type::CATEGORY_PLACE]?></h2>
                <div  class="list-group">
                <?php
                foreach ($list_types as $type)
                {
                    if ($type->common_id == Type::CATEGORY_PLACE)
                    {
                        echo Html::a($type->name, ['board/create', 'id' => $type->id], ['class' => 'list-group-item']);
                    }
                }
                ?>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div>
                <h2><?=$list_category[Type::CATEGORY_AUTO]?></h2>
                <div  class="list-group">
                    <?php

                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_AUTO)
                        {
                            echo Html::a($type->name, ['board/create', 'id' => $type->id], ['class' => 'list-group-item']);
                        }
                    }

                    ?>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div>
                <h2><?=$list_category[Type::CATEGORY_SERVICE]?></h2>
                <div  class="list-group">
                    <?php

                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_SERVICE)
                        {
                            echo Html::a($type->name, ['board/create', 'id' => $type->id], ['class' => 'list-group-item']);
                        }
                    }

                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div>
                <h2><?=$list_category[Type::CATEGORY_JOB]?></h2>
                <div  class="list-group">
                    <?php

                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_JOB)
                        {
                            echo Html::a($type->name, ['board/create', 'id' => $type->id], ['class' => 'list-group-item']);
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <h2><?=$list_category[Type::CATEGORY_ELECT]?></h2>
                <div  class="list-group">
                    <?php

                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_ELECT)
                        {
                            echo Html::a($type->name, ['board/create', 'id' => $type->id], ['class' => 'list-group-item']);
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <h2><?=$list_category[Type::CATEGORY_STUFF]?></h2>
                <div  class="list-group">
                    <?php

                    foreach ($list_types as $type)
                    {
                        if ($type->common_id == Type::CATEGORY_STUFF)
                        {
                            echo Html::a($type->name, ['board/create', 'id' => $type->id], ['class' => 'list-group-item']);
                        }
                    }

                    ?>
                </div>
            </div>
        </div>

    </div>



</div>
