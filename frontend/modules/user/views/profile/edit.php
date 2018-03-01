<?php

/** @var $model frontend\models\User */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <a href="<?php echo Url::to(['/user/profile/change-password']); ?>" class="btn btn-default">Change password</a>
            <br>
            <br>
            <?php $form = ActiveForm::begin(['action' => ['/user/profile/edit']]); ?>
                <?= $form->field($model, 'username'); ?>

                <?= $form->field($model, 'nickname')->textInput(); ?>

                <?= $form->field($model, 'about'); ?>

                <?= Html::submitButton('Save', ['class' => 'btn btn-default']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

