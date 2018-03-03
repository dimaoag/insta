<?php

/**
 * @var $this yii\web\View;
 * @var $post frontend\models\Post;
 * @var $currentUser frontend\models\User;
 * @var $commentForm frontend\modules\post\models\forms\CommentForm;
 * @var $comments  array frontend\modules\post\models\Comment;
 */

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;
use frontend\modules\post\models\Comment;
use yii\helpers\Url;

?>

<div class="page-posts no-padding">
    <div class="row">
        <div class="page page-post col-sm-12 col-xs-12 post-82">
            <div class="blog-posts blog-posts-large">
                <div class="row">
                    <!-- feed item -->
                    <article class="post col-sm-12 col-xs-12">
                        <div class="post-meta">
                            <div class="post-title">
                                <img src="<?php echo $post->getUserImage($post->user_id); ?>" class="author-image" />
                                <div class="author-name">
                                    <?php if ($post->user): ?>
                                    <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $post->user_id]); ?>">
                                        <?php echo $post->user->username; ?>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="post-type-image">
                            <img src="<?php echo $post->getImage(); ?>" alt="">
                        </div>
                        <div class="post-description">
                            <h4><?php echo Html::encode($post->description)?></h4>
                        </div>
                        <div class="post-bottom">
                            <div class="post-likes">
                                <a href="#" class="btn btn-secondary"><i class="fa fa-lg fa-heart-o"></i></a>
                                <span class="likes-count"><?php echo $post->countLikes(); ?> <?=Yii::t('post', 'Likes') ?></span>
                                <a href="" class="btn btn-default button-unlike <?php echo ($currentUser && $post->isLikeBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->id; ?>">
                                    <?=Yii::t('post', 'Unlike') ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                                </a>
                                <a href="" class="btn btn-default button-like <?php echo ($currentUser && $post->isLikeBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->id; ?>">
                                    <?=Yii::t('post', 'Like') ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                                </a>
                            </div>
                            <div class="post-comments">
                                <a href="#"><?php echo $post->count_comments; ?> <?=Yii::t('post', 'Comments') ?></a>

                            </div>
                            <div class="post-date">
                                <span><?php echo Yii::$app->formatter->asDatetime($post->created_at, "php:Y-d-m  H:i"); ?></span>
                            </div>
                            </div>
                        </div>
                    </article>
                    <!-- feed item -->


                    <div class="col-sm-12 col-xs-12">
                        <h4><?php echo $post->count_comments; ?> <?=Yii::t('post', 'Comments') ?></h4>
                        <div class="comments-post">

                            <div class="single-item-title"></div>
                            <div class="row">
                                <ul class="comment-list">
                                    <?php if(!empty($comments)): ?>
                                        <?php foreach ($comments as $comment): ?>
                                            <li class="comment">
                                                <div class="comment-user-image">
                                                    <img src="<?= Comment::getUserImage($comment['user_id']); ?>">
                                                </div>
                                                <div class="comment-info">
                                                    <h4 class="author">
                                                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $comment['user_id']]); ?>">
                                                            <?= Comment::getUserNameByUserId($comment['user_id']); ?>
                                                        </a>
                                                        <span><?= Comment::getDate($comment['updated_at']); ?></span>
                                                        <?php if(($currentUser->getId() == $comment['user_id']) || ($currentUser->getId() == $post->user_id)): ?>
                                                            <a href="<?php echo Url::to(['/post/default/delete-comment', 'comment_id' => $comment['id'], 'post_id' => $comment['post_id']])?>">
                                                                <i class="fa fa-trash-o comment-control comment-delete" aria-hidden="true"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </h4>
                                                    <p><?php echo Html::encode($comment['text']); ?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <!-- comments-post -->
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="comment-respond">
                            <h4><?=Yii::t('post', 'Leave a Reply') ?></h4>
                            <?php $form = ActiveForm::begin(['action' => ['/post/default/create-comment', 'id' => $post->id]]); ?>
                            <p class="comment-form-comment">
                                <?php echo $form->field($commentForm, 'text')
                                    ->textarea(['class' => 'form-control', 'rows' => 6, 'placeholder' => 'Text', 'aria-required' => true])->label(false); ?>
                            </p>
                            <?php echo Html::submitButton(Yii::t('post', 'Add Comment'), ['class' => 'btn btn-secondary'])?>

                            <?php ActiveForm::end(); ?>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile('@web/js/like4.js', [
   'depends' => YiiAsset::className(),
]);


?>


