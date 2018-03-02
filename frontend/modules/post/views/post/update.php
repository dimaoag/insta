<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\post\models\forms\PostUpdateForm */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm */


?>
<div class="post-view">

    <h1>Update post</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'picture')->fileInput(); ?>

    <?php echo $form->field($model, 'description'); ?>

    <?php echo Html::submitButton('Update', ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end() ?>

</div>
