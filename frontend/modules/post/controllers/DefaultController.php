<?php

namespace frontend\modules\post\controllers;

use frontend\components\Debug;
use frontend\modules\post\models\forms\CommentForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostForm;
use Yii;
use frontend\models\Post;
use frontend\models\User;
use frontend\modules\post\models\Comment;
use yii\filters\AccessControl;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'create-comment', 'like', 'unlike', 'delete-comment', 'complain'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }




    public function actionCreate(){

        /**@var $model PostForm */
        $model = new PostForm(Yii::$app->user->identity);

        if ($model->load(Yii::$app->request->post())){

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

        /**
         * @var $currentUser User;
         */
        $currentUser = Yii::$app->user->identity;

        /**@var $model CommentForm */

        $comments = Comment::find()->where(['post_id'=> $id])->orderBy(['created_at' => SORT_ASC])->asArray()->all();


        $commentForm = new CommentForm();


        return $this->render('view', [
            'post' => $this->findPost($id),
            'currentUser' => $currentUser,
            'commentForm' => $commentForm,
            'comments' => $comments,
        ]);
    }


    public function actionCreateComment($id){

        $model = new CommentForm();

        if (Yii::$app->request->isPost){

            if ($model->load(Yii::$app->request->post())){

                $user_id = Yii::$app->user->identity->getId();

                if ($model->save($user_id, $id)){

                    //return $this->goBack();
                    $post = Post::findOne($id);
                    $post->count_comments += 1;
                    $post->save(false);

                    return $this->redirect(['/post/'.$id]);
                }

            }

        }

    }

    public function actionDeleteComment($comment_id, $post_id){

        $comment = Comment::findOne($comment_id);
        $comment->delete();
        $post = Post::findOne($post_id);
        $post->count_comments -= 1;
        $post->save(false);

        return $this->redirect(['/post/'. $post_id]);

    }


    public function actionUpdateComment(){

        return $this->render('view');
    }



    public function actionLike(){


        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);

        /**
         * @var $currentUser User;
         */
        $currentUser = Yii::$app->user->identity;

        $post->like($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];

    }

    public function actionUnlike(){


        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);

        /**
         * @var $currentUser User;
         */
        $currentUser = Yii::$app->user->identity;

        $post->unlike($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];

    }


    private function findPost($id){

        if ($post = Post::findOne($id)){

            $post->count_views += 1;
            $post->save(false);

            return $post;
        }
        throw new NotFoundHttpException();
    }


    public function actionComplain(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $post_id = Yii::$app->request->post('post_id');

        /**
         * @var $currentUser User;
         */
        $currentUser = Yii::$app->user->identity;
        $post = Post::findOne($post_id);

        if ($post->complain($currentUser)){
            return [
                'success' => true,
                'text' => 'Post reported',
            ];
        }
        return [
            'success' => false,
            'text' => 'Error',
        ];

    }


}
