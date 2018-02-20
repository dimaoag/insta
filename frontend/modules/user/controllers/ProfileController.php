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

class ProfileController extends Controller
{

    /**
     * @param $id
     * @return string
     */
    public function actionView($id){

        return $this->render('view', [
            'user' => $this->findUserById($id),
        ]);
    }


    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */

    private function findUserById($id){

        if ($user = User::find()->where(['id' => $id])->one()){
            return $user;
        }

        throw new NotFoundHttpException();
    }

}