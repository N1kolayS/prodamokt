<?php

use yii\db\Migration;

/**
 * Handles the creation of table `town`.
 * Has foreign keys to the tables:
 *
 * - `region`
 */
class m170219_184113_create_town_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('town', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull(),
            'full_name' => $this->string()->notNull(),
            'default' => $this->integer()->defaultValue(0),
        ]);

        // creates index for column `region_id`
        $this->createIndex(
            'idx-town-region_id',
            'town',
            'region_id'
        );

        // add foreign key for table `region`
        $this->addForeignKey(
            'fk-town-region_id',
            'town',
            'region_id',
            'region',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `region`
        $this->dropForeignKey(
            'fk-town-region_id',
            'town'
        );

        // drops index for column `region_id`
        $this->dropIndex(
            'idx-town-region_id',
            'town'
        );

        $this->dropTable('town');
    }
}
