<?php
namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\components\Debug;
use frontend\models\Post;
use frontend\models\User;

class PostForm extends Model
{

    const MAX_DESCRIPTION_LENGHT = 1000;

    public $picture;
    public $description;

    private $user_id;

    public function rules()
    {
        return [
            [['picture'], 'file',
                'skipOnEmpty' => false,
                'extensions' => ['jpg', 'png', 'jpeg'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMazFileSize(),
            ],
            [['description'], 'string', 'max' => self::MAX_DESCRIPTION_LENGHT],
        ];
    }


    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }


    public function save(){

        if ($this->validate()){

            $post = new Post();
            $post->description = $this->description;
            $post->created_at = time();
            $post->filename = Yii::$app->storage->saveUploadedFile($this->picture);
            $post->user_id = $this->user_id;

            return $post->save(false);
        }
    }



    private function getMazFileSize(){
        return Yii::$app->params['maxFileSize'];
    }
}