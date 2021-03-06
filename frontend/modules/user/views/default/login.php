<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\modules\user\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('auth', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?=Yii::t('auth', 'Please fill out the following fields to login:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label(Yii::t('auth', 'Email')) ?>

                <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('auth', 'Password')) ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label(Yii::t('auth', 'rememberMe')) ?>

                <div style="color:#999;margin:1em 0">
                    <?=Yii::t('auth', 'If you forgot your password you can') ?> <?= Html::a(Yii::t('auth', 'reset it'), ['/user/default/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('auth', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-5">
            <h3><?=Yii::t('auth', 'Login with Facebook') ?></h3>
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['/user/default/auth'],
                'popupMode' => false,
            ]); ?>
        </div>
    </div>
</div>
