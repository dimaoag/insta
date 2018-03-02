<?php

/**
 * @var $this yii\web\View;
 * @var $feedItems[] frontend\models\Feed;
 * @var $feedItem frontend\models\Feed;
 * @var $currentUser frontend\models\User;
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\web\YiiAsset;

$this->title = 'News feed';
?>


<div class="page-posts no-padding">
    <div class="row">
        <div class="page page-post col-sm-12 col-xs-12">
            <div class="blog-posts blog-posts-large">

                <div class="row">
                    <!-- feed item -->

                    <?php if ($feedItems): ?>

                        <?php foreach ($feedItems as $feedItem) :?>

                            <article class="post col-sm-12 col-xs-12">
                                <div class="post-meta">
                                    <div class="post-title">
                                        <img src="<?= $feedItem->author_picture; ?>" class="author-image" />
                                        <div class="author-name">
                                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' =>($feedItem->author_nickname) ? $feedItem->author_nickname : $feedItem->author_id]); ?>">
                                                <?php echo Html::encode($feedItem->author_name); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-type-image">
                                    <a href="<?php echo Url::to(['/post/'.$feedItem->post_id])?>">
                                        <img src="<?php echo Yii::$app->storage->getFile($feedItem->post_filename); ?>" alt="">
                                    </a>
                                </div>
                                <div class="post-description">
                                    <p><?php echo HtmlPurifier::process($feedItem->post_description); ?></p>
                                </div>
                                <div class="post-bottom">
                                    <div class="post-likes">
                                        <a href="#" class="btn btn-secondary"><i class="fa fa-lg fa-heart-o"></i></a>
                                        <span class="likes-count"><?php echo $feedItem->countLikes(); ?> Likes</span>
                                        <a href="#" class="btn btn-default button-unlike <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "" : "display-none"; ?>" data-id="<?php echo $feedItem->post_id; ?>">
                                            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                                        </a>
                                        <a href="#" class="btn btn-default button-like <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "display-none" : ""; ?>" data-id="<?php echo $feedItem->post_id; ?>">
                                            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                                        </a>
                                    </div>
                                    <div class="post-comments">
                                        <a href="#"><?php echo $feedItem->countComments($feedItem->post_id); ?> Comments</a>

                                    </div>
                                    <div class="post-date">
                                        <span><?php echo Yii::$app->formatter->asDatetime($feedItem->post_created_at, "php:Y-d-m  H:i"); ?></span>
                                    </div>
                                    <div class="post-report">
                                        <?php if (!$feedItem->isReported($currentUser)):?>
                                            <a href="#" class="btn btn-default button-complain" data-id="<?= $feedItem->post_id ?>">
                                                Report post <i class="fa fa-cog fa-spin fa-fw icon-preloader" style="display: none"></i>
                                            </a>
                                        <?php else: ?>
                                            <p>Post has been reported</p>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </article>

                        <?php endforeach; ?>

                    <?php endif;?>

                    <!-- feed item -->
                </div>
            </div>
        </div>
    </div>
</div>



<?php
$this->registerJsFile('@web/js/like4.js', [
    'depends' => YiiAsset::className(),
]);

$this->registerJsFile('@web/js/complaints.js', [
    'depends' => YiiAsset::className(),
]);

?>


