<?php
namespace frontend\modules\user\models\forms;


use Yii;
use yii\base\Model;
use frontend\models\User;


class ChangePasswordForm extends Model
{
    public $password_1;
    public $password_2;


    public function rules()
    {
        return [
            [['password_2', 'password_1'], 'string', 'min' => 6],
        ];
    }

    public function checkAndSavePassword($user_id){

        if ($this->password_1 == $this->password_2){
            $user = User::findOne($user_id);
            $user->changePassword($this->password_2);

            if ($user->save(false)){

                return true;
            }
        }
        return false;
    }




}


