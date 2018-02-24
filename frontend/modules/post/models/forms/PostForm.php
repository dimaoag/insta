<?php
namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\components\Debug;
use frontend\models\Post;
use frontend\models\User;
use Intervention\Image\ImageManager;


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
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
    }

    public function resizePicture(){

        $width = Yii::$app->params['postPicture']['maxWidth'];
        $height = Yii::$app->params['postPicture']['maxHeight'];

        $manager = new ImageManager(['driver' => 'imagick']);
        $image = $manager->make($this->picture->tempName);

        $image->resize($width,$height, function ($constrain){
            $constrain->aspectRatio();
            $constrain->upsize();
        })->save();

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