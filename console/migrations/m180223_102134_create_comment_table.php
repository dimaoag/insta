<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180223_102134_create_comment_table extends Migration
{


    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'post_id' => $this->integer(),
            'text' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->tableOptions);
    }
    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('comment');
    }
}
