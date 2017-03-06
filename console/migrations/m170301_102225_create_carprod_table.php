<?php

use yii\db\Migration;

/**
 * Handles the creation of table `carprod`.
 */
class m170301_102225_create_carprod_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('carprod', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'home' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('carprod');
    }
}
