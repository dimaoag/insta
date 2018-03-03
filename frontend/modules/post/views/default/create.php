<?php
/**
 * @var $this yii\web\View;
 * @var $model frontend\modules\post\models\forms\PostForm;
 */

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;

?>

<div class="post-default-index">

    <h1><?= Yii::t('my-profile', 'Create post') ?></h1>

    <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($model, 'picture')->fileInput()->label(Yii::t('my-profile', 'Image')); ?>

        <?php echo $form->field($model, 'description')->label(Yii::t('my-profile', 'Description')); ?>

        <?php echo Html::submitButton(Yii::t('my-profile', 'Create'), ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end() ?>

</div>


