<?php

namespace frontend\models;

use Yii;
use yii\redis\Connection;
use frontend\models\Post;

/**
 * This is the model class for table "feed".
 *
 * @property int $id
 * @property int $user_id
 * @property int $author_id
 * @property string $author_name
 * @property string $author_nickname
 * @property string $author_picture
 * @property int $post_id
 * @property string $post_filename
 * @property string $post_description
 * @property int $post_created_at
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feed';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'author_id' => 'Author ID',
            'author_name' => 'Author Name',
            'author_nickname' => 'Author Nickname',
            'author_picture' => 'Author Picture',
            'post_id' => 'Post ID',
            'post_filename' => 'Post Filename',
            'post_description' => 'Post Description',
            'post_created_at' => 'Post Created At',
        ];
    }

    public function countLikes(){

        /** @var $redis Connection */
        $redis = Yii::$app->redis;

        return $redis->scard("post:{$this->post_id}:likes");
    }


    public function countComments($post_id){

        if ($post = Post::findOne($post_id)){
            return $post->count_comments;
        }

    }

    public function countViews($post_id){
        $post = Post::findOne($post_id);

        return $post->count_views;
    }

    /**
     * @param $user User
     * @return mixed
     */
    public function isReported($user){
        /** @var $redis Connection */
        $redis = Yii::$app->redis;

        //проверяем есть ли в множестве "post:{$this->post_id}:complaints"  запись $user->getId()
        return $redis->sismember("post:{$this->post_id}:complaints", $user->getId());
    }

}
