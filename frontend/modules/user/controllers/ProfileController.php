<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 20.02.18
 * Time: 14:03
 */

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;
use frontend\components\Debug;
use yii\web\Response;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use frontend\modules\user\models\forms\ChangePasswordForm;

class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['subscribe', 'unsubscribe', 'delete-picture', 'edit', 'change-password'],
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
     * @param $nickname
     * @return string
     */
    public function actionView($nickname){

        /**@var  $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $posts = $currentUser->getPosts();

        $modelPicture = new PictureForm();

        return $this->render('view', [
            'user' => $this->findUserById($nickname),
            'currentUser' => $currentUser,
            'modelPicture' => $modelPicture,
            'posts' => $posts,
        ]);
    }


    public function actionUploadPicture(){

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
     * @param $nickname
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */

    private function findUserById($nickname){

        if ($user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one()){
            return $user;
        }

        throw new NotFoundHttpException();
    }


    public function actionSubscribe($id){


        /**@var  $currentUser User */
        $currentUser = Yii::$app->user->identity;

        /**@var  $user User */
        $user = $this->findUser($id);

        $currentUser->followUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);

    }


    public function actionUnsubscribe($id){


        /**@var  $currentUser User */
        $currentUser = Yii::$app->user->identity;

        /**@var  $user User */
        $user = $this->findUser($id);

        $currentUser->unfollowUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);

    }




    /**
     * @param $id
     * @return User
     * @throws NotFoundHttpException
     */

    private function findUser($id){

        if ($user = User::findOne($id)){
            return $user;
        }
        throw new NotFoundHttpException();
    }


    public function actionDeletePicture(){


        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        if ($currentUser->deletePicture()) {
                Yii::$app->session->setFlash('success', 'Picture deleted');
            } else {
                Yii::$app->session->setFlash('danger', 'Error');
            }

        return $this->redirect(['/user/profile/view', 'nickname' => $currentUser->getNickname()]);
    }


    public function actionEdit(){

        $model = User::findOne(Yii::$app->user->identity->getId());

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success','data changed');
            return $this->redirect(['/profile/'. Yii::$app->user->identity->getId()]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }


    /**
     * @return string|Response
     */
    public function actionChangePassword(){

        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){

            if ($model->checkAndSavePassword(Yii::$app->user->identity->getId())){
                Yii::$app->session->setFlash('success','Password changed');
                return $this->redirect(['/profile/'. Yii::$app->user->identity->getId()]);
            } else {
                Yii::$app->session->setFlash('warning','don\'t match passwords!');
                return $this->redirect(['/user/profile/change-password']);
            }

        }


        return $this->render('change-password', [
            'model' => $model,
        ]);
    }





//    public function actionGenerate(){
//
//        $faker = \Faker\Factory::create();
//
//        for ($i = 0; $i < 100; $i++){
//
//            $user = new User([
//                'username' => $faker->name,
//                'email' => $faker->email,
//                'about' => $faker->text(200),
//                'nickname' => $faker->regexify('[A-Za-z0-9_]{5,15}'),
//                'auth_key' => Yii::$app->security->generateRandomString(),
//                'password_hash' => Yii::$app->security->generateRandomString(),
//                'created_at' => $time = time(),
//                'updated_at' => $time,
//            ]);
//            $user->save(false);
//        }
//
//    }

}