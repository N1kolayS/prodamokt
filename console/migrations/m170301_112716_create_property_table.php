<?php

use yii\db\Migration;

/**
 * Handles the creation of table `property`.
 * Has foreign keys to the tables:
 *
 * - `type`
 */
class m170301_112716_create_property_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('property', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'type_id' => $this->integer()->notNull(),
            'mode' => $this->integer()->defaultValue(0),
            'modelName' => $this->string(50),
            'value' => $this->string(255),
            'sort' => $this->integer()->defaultValue(0),
        ]);

        // creates index for column `type_id`
        $this->createIndex(
            'idx-property-type_id',
            'property',
            'type_id'
        );

        // add foreign key for table `type`
        $this->addForeignKey(
            'fk-property-type_id',
            'property',
            'type_id',
            'type',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `type`
        $this->dropForeignKey(
            'fk-property-type_id',
            'property'
        );

        // drops index for column `type_id`
        $this->dropIndex(
            'idx-property-type_id',
            'property'
        );

        $this->dropTable('property');
    }
}
