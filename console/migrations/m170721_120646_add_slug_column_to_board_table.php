<?php

use yii\db\Migration;

/**
 * Handles adding slug to table `board`.
 */
class m170721_120646_add_slug_column_to_board_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('board', 'slug', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('board', 'slug');
    }
}
