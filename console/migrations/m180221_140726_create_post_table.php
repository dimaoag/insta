<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180221_140726_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'filename' => $this->string()->notNull(),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
        ], $this->tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('post');
    }
}
