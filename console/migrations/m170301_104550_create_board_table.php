<?php

use yii\db\Migration;

/**
 * Handles the creation of table `board`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `type`
 * - `town`
 */
class m170301_104550_create_board_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('board', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'town_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'finished_at' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'body' => $this->text(),
            'cost' => $this->decimal(10,2)->defaultValue(0),
            'views' => $this->integer()->defaultValue(0),
            'looks' => $this->integer()->defaultValue(0),
            'enable' => $this->integer()->defaultValue(1),
            'marked' => $this->integer()->defaultValue(0),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-board-user_id',
            'board',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-board-user_id',
            'board',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `type_id`
        $this->createIndex(
            'idx-board-type_id',
            'board',
            'type_id'
        );

        // add foreign key for table `type`
        $this->addForeignKey(
            'fk-board-type_id',
            'board',
            'type_id',
            'type',
            'id',
            'CASCADE'
        );

        // creates index for column `town_id`
        $this->createIndex(
            'idx-board-town_id',
            'board',
            'town_id'
        );

        // add foreign key for table `town`
        $this->addForeignKey(
            'fk-board-town_id',
            'board',
            'town_id',
            'town',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-board-user_id',
            'board'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-board-user_id',
            'board'
        );

        // drops foreign key for table `type`
        $this->dropForeignKey(
            'fk-board-type_id',
            'board'
        );

        // drops index for column `type_id`
        $this->dropIndex(
            'idx-board-type_id',
            'board'
        );

        // drops foreign key for table `town`
        $this->dropForeignKey(
            'fk-board-town_id',
            'board'
        );

        // drops index for column `town_id`
        $this->dropIndex(
            'idx-board-town_id',
            'board'
        );

        $this->dropTable('board');
    }
}
