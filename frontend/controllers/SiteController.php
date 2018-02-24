<?php
namespace frontend\controllers;

use frontend\models\User;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        /**
         * @var $currentUser User;
         */
        $currentUser = Yii::$app->user->identity;

        $limit = Yii::$app->params['feedPostLimit'];
        $feedItems = $currentUser->getFeed($limit);

        return $this->render('index', [
            'feedItems' => $feedItems,
            'carrentUser' => $currentUser,
        ]);
    }




}
