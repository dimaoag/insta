<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\post\models\forms\PostUpdateForm */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm */


?>
<div class="post-view">

    <h1><?= Yii::t('my-profile', 'Update post') ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'picture')->fileInput()->label(Yii::t('my-profile', 'Image')); ?>

    <?php echo $form->field($model, 'description')->label(Yii::t('my-profile', 'Description')); ?>

    <?php echo Html::submitButton(Yii::t('my-profile', 'Update'), ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end() ?>

</div>
