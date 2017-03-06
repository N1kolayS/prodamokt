<?php

use yii\db\Migration;

/**
 * Handles the creation of table `region`.
 */
class m170219_183917_create_region_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('region', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'full_name' => $this->string()->notNull(),
            'default' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('region');
    }
}
