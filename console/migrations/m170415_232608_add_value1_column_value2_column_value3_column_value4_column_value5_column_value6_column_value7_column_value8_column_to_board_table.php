<?php

use yii\db\Migration;

/**
 * Handles adding value1_column_value2_column_value3_column_value4_column_value5_column_value6_column_value7_column_value8 to table `board`.
 */
class m170415_232608_add_value1_column_value2_column_value3_column_value4_column_value5_column_value6_column_value7_column_value8_column_to_board_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('board', 'value1', $this->string());
        $this->addColumn('board', 'value2', $this->string());
        $this->addColumn('board', 'value3', $this->string());
        $this->addColumn('board', 'value4', $this->string());
        $this->addColumn('board', 'value5', $this->string());
        $this->addColumn('board', 'value6', $this->string());
        $this->addColumn('board', 'value7', $this->string());
        $this->addColumn('board', 'value8', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('board', 'value1');
        $this->dropColumn('board', 'value2');
        $this->dropColumn('board', 'value3');
        $this->dropColumn('board', 'value4');
        $this->dropColumn('board', 'value5');
        $this->dropColumn('board', 'value6');
        $this->dropColumn('board', 'value7');
        $this->dropColumn('board', 'value8');
    }
}
