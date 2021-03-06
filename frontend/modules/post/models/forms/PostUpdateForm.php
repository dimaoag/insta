<?php
namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\components\Debug;
use frontend\models\Post;
use frontend\models\User;
use Intervention\Image\ImageManager;
use frontend\models\events\PostCreatedEvent;
use frontend\models\Feed;

class PostUpdateForm extends Model
{

    const MAX_DESCRIPTION_LENGHT = 1000;

    public $picture;
    public $description;


    public function rules()
    {
        return [
            [['picture'], 'file',
                'skipOnEmpty' => true,
                'extensions' => ['jpg', 'png', 'jpeg'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMazFileSize(),
            ],
            [['description'], 'string', 'max' => self::MAX_DESCRIPTION_LENGHT],
        ];
    }


    public function __construct()
    {
        if($this->picture){
            $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
        }

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



    public function update($post_id){

        if ($this->validate()){

            $post = Post::findOne($post_id);

            if($this->picture){
                $post->checkDeleteImage();
                $post->filename = Yii::$app->storage->saveUploadedFile($this->picture);

                $feeds = Feed::find()->where(['post_id' => $post_id])->all();

                /** @var  $feed Feed */
                foreach ($feeds as $feed){
                    $feed->post_filename = $post->filename;
                    $feed->save(false);
                }
            }

            $post->description = $this->description;

            if ($post->save(false)){
                return true;
            }
        }
        return false;
    }



    private function getMazFileSize(){
        return Yii::$app->params['maxFileSize'];
    }
}