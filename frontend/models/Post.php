<?php

namespace frontend\models;

use Yii;
use yii\redis\Connection;
use frontend\modules\post\models\Comment;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $description
 * @property int $created_at
 * @property int $count_comments
 * @property int $count_views
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public function getImage(){

        return Yii::$app->storage->getFile($this->filename);
    }

    public function getUser(){

        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getId(){
        return $this->id;
    }

    public function like(User $user){

        /** @var $redis Connection */
        $redis = Yii::$app->redis;

        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
        $redis->sadd("user:{$user->getId()}:likes", $this->getId());
    }

    public function unlike(User $user){

        /** @var $redis Connection */
        $redis = Yii::$app->redis;

        $redis->srem("post:{$this->getId()}:likes", $user->getId());
        $redis->srem("user:{$user->getId()}:likes", $this->getId());
    }


    public function countLikes(){
        /** @var $redis Connection */
        $redis = Yii::$app->redis;

        return $redis->scard("post:{$this->getId()}:likes");
    }

    public function isLikeBy(User $user){
        /** @var $redis Connection */
        $redis = Yii::$app->redis;

        return $redis->sismember("post:{$this->getId()}:likes", $user->getId());
    }


    public function getComments(){
        return $this->hasMany(Comment::className(), ['post_id', 'id']);
    }


}
