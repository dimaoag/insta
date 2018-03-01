<?php

use yii\helpers\Html;
use dosamigos\fileupload\FileUpload;


/* @var $this yii\web\View */
/* @var $model frontend\models\Post */

$this->title = $model->id;

?>
<div class="post-view">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <img src="<?= $model->getImage(); ?>">

            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">

                <p>
                    <?= Html::encode($model->description); ?>
                </p>
            </div>
        </div>
    </div>
</div>
