<?php
namespace frontend\controllers;

use frontend\models\User;
use yii\debug\models\search\Debug;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\web\Cookie;

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


    public function actionLanguage(){

        $languages = ['ru-RU', 'en-US'];

        $language = Yii::$app->request->post('language');

        if (in_array($language, $languages)){

            $languageCookie = new Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, //30 days
            ]);

            Yii::$app->response->cookies->add($languageCookie);

            return $this->redirect(Yii::$app->request->referrer); //возвращаем на ту страницу где пользователь находился
        }

        die('Error!');
    }

}
