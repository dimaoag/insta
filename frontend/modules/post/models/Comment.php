<?php
namespace frontend\modules\post\models;


use frontend\models\User;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use Yii;


/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 */

class Comment extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
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


    public static function getUserNameByUserId($id){

        $user = User::find()->select('username')->where(['id' => $id])->asArray()->one();

        return $user['username'];
    }

    public static function getDate($date){
        return Yii::$app->formatter->asDatetime($date, "php:Y-d-m  H:i");
    }


}