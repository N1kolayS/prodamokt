<?php

use yii\db\Migration;

/**
 * Handles adding number to table `property`.
 */
class m170415_224704_add_number_column_to_property_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('property', 'number', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('property', 'number');
    }
}
