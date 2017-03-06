<?php

use yii\db\Migration;

/**
 * Handles the creation of table `type`.
 */
class m170301_102902_create_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'sort' => $this->integer()->defaultValue(0),
            'common_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('type');
    }
}
