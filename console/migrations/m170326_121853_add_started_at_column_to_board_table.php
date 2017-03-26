<?php

use yii\db\Migration;

/**
 * Handles adding started_at to table `board`.
 */
class m170326_121853_add_started_at_column_to_board_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('board', 'started_at', $this->integer()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('board', 'started_at');
    }
}
