<?php

/**
 * @var $this yii\web\View;
 * @var $post frontend\models\Post;
 * @var $carrentUser frontend\models\User;
 * @var $commentForm frontend\modules\post\models\forms\CommentForm;
 * @var $comments  array frontend\modules\post\models\Comment;
 */

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;
use frontend\modules\post\models\Comment;

?>

<div class="post-default-index">


    <div class="row">

        <div class="col-md-12">
            <?php if ($post->user): ?>
                <?php echo $post->user->username; ?>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <img src="<?php echo $post->getImage(); ?>">
        </div>
        <div class="col-md-12">
            <?php echo Html::encode($post->description)?>
        </div>


    </div>

    <hr>

    <div class="col-md-12">
        Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>
        <a href="" class="btn btn-primary button-unlike <?php echo ($carrentUser && $post->isLikeBy($carrentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->id; ?>">
            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>
        <a href="" class="btn btn-primary button-like <?php echo ($carrentUser && $post->isLikeBy($carrentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->id; ?>">
            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>
    </div>
    <br><br>

        <div class="container">
                    <?php if(!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5><?= Comment::getUserNameByUserId($comment['user_id']); ?></h5>
                                    <small><?= Comment::getDate($comment['updated_at']); ?></small>
                                    <br>
                                    <p><?php echo Html::encode($comment['text']); ?></p>
                                    <hr>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['action' => ['/post/default/create-comment', 'id' => $post->id],
                        'options' => ['class' => 'form-horizontal contact-form', 'role' => 'form']]); ?>

                    <?php echo $form->field($commentForm, 'text')->textarea(['class' => 'form-control'])->label(false); ?>

                    <button type="submit" class="btn btn-success btn-block">Add</button>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>








</div>


<?php
$this->registerJsFile('@web/js/like4.js', [
   'depends' => YiiAsset::className(),
]);

?>


