<?php

use yii\db\Migration;

/**
 * Handles adding sms_code_activate to table `user`.
 */
class m170321_162811_add_sms_code_activate_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'sms_code_activate', $this->string(10));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'sms_code_activate');
    }
}
