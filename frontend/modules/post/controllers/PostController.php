<?php

namespace frontend\modules\post\controllers;

use frontend\components\Debug;
use Yii;
use frontend\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\User;
use yii\filters\AccessControl;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostUpdateForm;
use frontend\models\Feed;
use frontend\modules\post\models\Comment;
/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
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

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['user_id' => Yii::$app->user->identity->getId()]),
        ]);

        $dataProvider->pagination->pageSize = 15;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        /**@var $model PostUpdateForm */
        $model = new PostUpdateForm();

        $post = Post::findOne($id);
        $model->description = $post->description;

        if ($model->load(Yii::$app->request->post())){

            if ($model->picture = UploadedFile::getInstance($model, 'picture')){
                $model->picture = UploadedFile::getInstance($model, 'picture');
            }

            if ($model->update($id)){

                    Yii::$app->session->setFlash('success', 'Post updated!');
                return $this->redirect(['/post/post/index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);


    }


    public function actionUploadImage(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');

        if ($model->validate()){

            /**
             * @var $user User
             */
            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture);

            if ($user->save(false, ['picture'])){
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }



    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        /**
         * @var $model Post
         */
        $model = $this->findModel($id);
        $model->checkDeleteImage();
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
