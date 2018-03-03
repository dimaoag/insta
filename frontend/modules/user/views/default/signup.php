<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('auth', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?=Yii::t('auth', 'Please fill out the following fields to signup:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Yii::t('auth', 'Username')) ?>

                <?= $form->field($model, 'email')->label(Yii::t('auth', 'Email')) ?>

                <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('auth', 'Password')) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('auth', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
