<?php

/** @var $model frontend\modules\user\models\forms\ChangePasswordForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">

            <?php $form = ActiveForm::begin(['action' => ['/user/profile/change-password']]); ?>
            <?= $form->field($model, 'password_1')->passwordInput(); ?>

            <?= $form->field($model, 'password_2')->passwordInput(); ?>

            <?= Html::submitButton('Change', ['class' => 'btn btn-default']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
