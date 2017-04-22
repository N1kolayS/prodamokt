<?php

use yii\db\Migration;

/**
 * Handles adding sms_reset_token to table `user`.
 */
class m170421_063547_add_sms_reset_token_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'sms_reset_token', $this->string(10));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'sms_reset_token');
    }
}
