<?php

use yii\db\Migration;

/**
 * Handles adding post_vk to table `board`.
 */
class m170330_201603_add_post_vk_column_to_board_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('board', 'post_vk', $this->integer()->Null());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('board', 'post_vk');
    }
}
