<?php
namespace frontend\controllers;

use frontend\models\User;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;

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
                'only' => ['index', 'users'],
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
            'currentUser' => $currentUser,
        ]);
    }

    public function actionUsers(){

        $order = ['username' => SORT_ASC];
        $query = User::find();

        $count = $query->count();
        $pageSize = 35;

        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $query->offset($pagination->offset)->limit($pagination->limit)->orderBy($order)->all();

        return $this->render('users',[
            'users' => $users,
            'pagination' => $pagination,
        ]);
    }

}
