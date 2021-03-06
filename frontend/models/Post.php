<?php

namespace frontend\models;

use Codeception\Util\Debug;
use function Symfony\Component\Debug\Tests\testHeader;
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
 * @property int $complaints
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

    public function getUserImage($user_id){
        $user = User::findOne($user_id);
        return $user->getPicture();
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

        return $this->hasMany(Comment::className(),['post_id' => 'id']);
    }

    public function getFeeds(){

        return $this->hasMany(Feed::className(), ['post_id' => 'id']);
    }



    public function checkDeleteImage(){

        $postPictureCount = Post::find()
            ->select(['COUNT(*) AS count'])
            ->where(['filename' => $this->filename])
            ->asArray()
            ->all();

        $userPictureCount = User::find()
            ->select(['COUNT(*) AS count'])
            ->where(['picture' => $this->filename])
            ->asArray()
            ->all();

        if (($postPictureCount[0]['count'] + $userPictureCount[0]['count']) < 2) {
            Yii::$app->storage->deleteFile($this->filename);
        }

    }


    /**
     * @param $user User
     */
    public function complain($user){

        /** @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->getId()}:complaints";

        if (!$redis->sismember($key, $user->getId())){ //если нет жалоб то добавляем
            $redis->sadd($key, $user->getId());
            $this->complaints++;
            return $this->save(false, ['complaints']);
        }

    }

    public function beforeDelete()
    {
        if(parent::beforeDelete()){

            /** @var $redis Connection */

            $redis = Yii::$app->redis;
            $key = "post:{$this->id}:likes";

            $redis->del($key);

            //Feed::deleteAll(['post_id' => $this->id]);
            //Comment::deleteAll(['post_id' => $this->id]);

            if ($this->comments){
                foreach ($this->comments as $comment){
                    /** @var $comment Comment */
                    $comment->delete();
                }
            }

            if ($this->feeds){
                foreach ($this->feeds as $feed){
                    /** @var $feed Feed */
                    $feed->delete();
                }
            }

            return true;
        }

        return false;
    }

}
