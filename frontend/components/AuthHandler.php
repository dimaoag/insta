<?php

namespace app\components;

use Yii;
use frontend\models\Auth;
use frontend\models\User;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use frontend\components\Debug;


class AuthHandler
{

    /**
     * @var ClientInterface
     */

    private $client;


    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

    }


    public function handle(){

        if (!Yii::$app->user->isGuest){

            return;
        }

        $attributes = $this->client->getUserAttributes();

        //Debug::debugging($attributes);
        $auth = $this->findAuth($attributes);

        if ($auth){

            /* @var User $user */
            $user = $auth->user;

            return Yii::$app->user->login($user);
        }
        if ($user = $this->createAccount($attributes)){
            return Yii::$app->user->login($user);
        }


    }


    private function findAuth($attributes){

        $id = ArrayHelper::getValue($attributes, 'id');
        $params = [
            'source_id' => $id,
            'source' => $this->client->getId(), //facebook
        ];

        return Auth::find()->where($params)->one();
    }


    private function createAccount($attributes){

        $id = ArrayHelper::getValue($attributes, 'id');
        $name = ArrayHelper::getValue($attributes, 'name');
        $email = ArrayHelper::getValue($attributes, 'email');

        if ($email !== null && User::find()->where(['email' => $email])->exists()){
            return;
        }

        $user = $this->createUser($email, $name);

        $transaction = User::getDb()->beginTransaction();
        if ($user->save()){
            $auth = $this->createAuth($user->id, $id);
            if ($auth->save()){
                $transaction->commit();
                return $user;
            }
        }

        $transaction->rollBack();

    }

    private function createUser($email, $name){

        return new User([
            'username' => $name,
            'email' => $email,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString()),
            'created_at' => $time = time(),
            'updated_at' => $time,
        ]);
    }

    private function createAuth($userId, $sourceId){
        return new Auth([
            'user_id' => $userId,
            'source_id' => (string)$sourceId,
            'source' => $this->client->getId(),
        ]);
    }





}