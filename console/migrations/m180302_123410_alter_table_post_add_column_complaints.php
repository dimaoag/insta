<?php

use yii\db\Migration;

/**
 * Class m180302_123410_alter_table_post_add_column_complaints
 */
class m180302_123410_alter_table_post_add_column_complaints extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%post}}', 'complaints', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%post}}', 'complaints');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180302_123410_alter_table_post_add_column_complaints cannot be reverted.\n";

        return false;
    }
    */
}
