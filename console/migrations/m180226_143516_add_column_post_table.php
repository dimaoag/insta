<?php

use yii\db\Migration;

/**
 * Class m180226_143516_add_column_post_table
 */
class m180226_143516_add_column_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('post', 'count_comments', $this->integer(11)->defaultValue(0));
        $this->addColumn('post', 'count_views', $this->integer(11)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('post', 'count_comments');
        $this->dropColumn('post', 'count_views');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180226_143516_add_column_post_table cannot be reverted.\n";

        return false;
    }
    */
}
