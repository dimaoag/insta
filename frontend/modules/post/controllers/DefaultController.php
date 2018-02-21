<?php

namespace frontend\modules\post\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostForm;
use Yii;
use frontend\models\Post;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{

    public function actionCreate(){

        /**@var $model PostForm */
        $model = new PostForm(Yii::$app->user->identity->getId());

        if ($model->load(\Yii::$app->request->post())){

            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()){
                Yii::$app->session->setFlash('success', 'Post created!');
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    public function actionView($id){

        return $this->render('view', [
            'post' => $this->findPost($id),
        ]);
    }

    private function findPost($id){

        if ($post = Post::findOne($id)){
            return $post;
        }
        throw new NotFoundHttpException();
    }



}
