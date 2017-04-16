<?php

use yii\db\Migration;

/**
 * Handles dropping sort from table `property`.
 */
class m170415_224606_drop_sort_column_from_property_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('property', 'sort');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('property', 'sort', $this->integer());
    }
}
