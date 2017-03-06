<?php

use yii\db\Migration;

/**
 * Handles the creation of table `carmodel`.
 * Has foreign keys to the tables:
 *
 * - `carprod`
 */
class m170301_102414_create_carmodel_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('carmodel', [
            'id' => $this->primaryKey(),
            'carprod_id' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull(),
        ]);

        // creates index for column `carprod_id`
        $this->createIndex(
            'idx-carmodel-carprod_id',
            'carmodel',
            'carprod_id'
        );

        // add foreign key for table `carprod`
        $this->addForeignKey(
            'fk-carmodel-carprod_id',
            'carmodel',
            'carprod_id',
            'carprod',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `carprod`
        $this->dropForeignKey(
            'fk-carmodel-carprod_id',
            'carmodel'
        );

        // drops index for column `carprod_id`
        $this->dropIndex(
            'idx-carmodel-carprod_id',
            'carmodel'
        );

        $this->dropTable('carmodel');
    }
}
