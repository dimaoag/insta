<?php

namespace backend\models;

use Yii;

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
            'count_comments' => 'Count Comments',
            'count_views' => 'Count Views',
            'complaints' => 'Complaints',
        ];
    }

    public static function findComplaints(){

        return Post::find()->where('complaints > 0')->orderBy('complaints DESC');
    }


    public function getImage(){
        return Yii::$app->storage->getFile($this->filename);
    }
}
