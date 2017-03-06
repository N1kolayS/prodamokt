<?php

use yii\db\Migration;

/**
 * Handles the creation of table `board_property`.
 * Has foreign keys to the tables:
 *
 * - `board`
 * - `property`
 */
class m170301_112844_create_junction_board_and_property_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('board_property', [
            'board_id' => $this->integer(),
            'property_id' => $this->integer(),
            'value' => $this->string(50),
            'PRIMARY KEY(board_id, property_id)',
        ]);

        // creates index for column `board_id`
        $this->createIndex(
            'idx-board_property-board_id',
            'board_property',
            'board_id'
        );

        // add foreign key for table `board`
        $this->addForeignKey(
            'fk-board_property-board_id',
            'board_property',
            'board_id',
            'board',
            'id',
            'CASCADE'
        );

        // creates index for column `property_id`
        $this->createIndex(
            'idx-board_property-property_id',
            'board_property',
            'property_id'
        );

        // add foreign key for table `property`
        $this->addForeignKey(
            'fk-board_property-property_id',
            'board_property',
            'property_id',
            'property',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `board`
        $this->dropForeignKey(
            'fk-board_property-board_id',
            'board_property'
        );

        // drops index for column `board_id`
        $this->dropIndex(
            'idx-board_property-board_id',
            'board_property'
        );

        // drops foreign key for table `property`
        $this->dropForeignKey(
            'fk-board_property-property_id',
            'board_property'
        );

        // drops index for column `property_id`
        $this->dropIndex(
            'idx-board_property-property_id',
            'board_property'
        );

        $this->dropTable('board_property');
    }
}
