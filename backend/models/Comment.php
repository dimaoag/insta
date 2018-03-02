<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'post_id' => 'Post ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
