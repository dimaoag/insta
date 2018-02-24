<?php

use yii\db\Migration;

/**
 * Handles the creation of table `feed`.
 */
class m180224_111218_create_feed_table extends Migration
{



    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('feed', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'author_id' => $this->integer(),
            'author_name' => $this->string(),
            'author_nickname' => $this->string(70),
            'author_picture' => $this->string(),
            'post_id' => $this->integer(),
            'post_filename' => $this->string()->notNull(),
            'post_description' => $this->string(),
            'post_created_at' => $this->integer()->notNull(),
        ], $this->tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('feed');
    }
}
