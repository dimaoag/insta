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
use yii\helpers\Url;

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
            <div class="comments-container">
                <h2>Comments:</h2>
                <?php if(!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="row">
                            <div class="col-md-10 comment-item">
                                <h5><?= Comment::getUserNameByUserId($comment['user_id']); ?>
                                    <<?= Comment::getDate($comment['updated_at']); ?>>
                                    <?php if($carrentUser->getId() == $comment['user_id']): ?>
                                        <a href="<?php echo Url::to(['/post/default/delete-comment', 'id' => $comment['id'], 'post_id' => $comment['post_id']])?>">
                                            <i class="fa fa-2x fa-trash-alt comment-control comment-delete"></i>
                                        </a>
                                    <?php endif; ?>
                                </h5>
                                <br>
                                <h4><?php echo Html::encode($comment['text']); ?></h4>
                            </div>
                        </div>
                        <br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <?php $form = ActiveForm::begin(['action' => ['/post/default/create-comment', 'id' => $post->id],
                        'options' => ['class' => 'form-horizontal contact-form', 'role' => 'form']]); ?>

                    <?php echo $form->field($commentForm, 'text')->textarea(['class' => 'form-control'])->label(false); ?>

                    <button type="submit" class="btn btn-success btn-block">Add Comment</button>

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


