<?php

/**
 * @var $this yii\web\View;
 * @var $feedItems[] frontend\models\Feed;
 * @var $currentUser frontend\models\User;
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\web\YiiAsset;

$this->title = 'My Yii Application';
?>
<div class="site-index">
<?php if ($feedItems): ?>

    <?php foreach ($feedItems as $feedItem) :?>

        <div class="col-md-12">
            <div class="col-md-12">
                <img src="<?= $feedItem->author_picture; ?>" alt="img" style="width: 30px; height: 30px">
                <a href="<?php echo Url::to(['/user/profile/view', 'nickname' =>($feedItem->author_nickname) ? $feedItem->author_nickname : $feedItem->author_id]); ?>">
                    <?php echo Html::encode($feedItem->author_name); ?>
                </a>
            </div>
            <a href="<?php echo Url::to(['/post/'.$feedItem->post_id])?>">
                <img src="<?php echo Yii::$app->storage->getFile($feedItem->post_filename); ?>" alt="img">
            </a>
            <div class="col-md-12">
                <?php echo HtmlPurifier::process($feedItem->post_description); ?>
            </div>
            <div class="col-md-12">
                <?php echo Yii::$app->formatter->asDatetime($feedItem->post_created_at, "php:Y-d-m  H:i"); ?>
            </div>
            <div class="col-md-12">
                Comments: <small class="likes-count"><?php echo $feedItem->countComments($feedItem->post_id); ?></small>
                Views: <small class="likes-count"><?php echo $feedItem->countViews($feedItem->post_id); ?></small>
                Likes: <small class="likes-count"><?php echo $feedItem->countLikes(); ?></small>

                <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "" : "display-none"; ?>" data-id="<?php echo $feedItem->post_id; ?>">
                    Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                </a>
                <a href="#" class="btn btn-primary button-like <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "display-none" : ""; ?>" data-id="<?php echo $feedItem->post_id; ?>">
                    Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                </a>

            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    <?php endforeach; ?>

<?php endif;?>

</div>


<?php
$this->registerJsFile('@web/js/like4.js', [
    'depends' => YiiAsset::className(),
]);

?>

