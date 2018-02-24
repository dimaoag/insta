<?php

/**
 * @var $this yii\web\View;
 * @var $feedItems[] frontend\models\Feed;
 * @var $currentUser frontend\models\User;
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

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
            <img src="<?php echo Yii::$app->storage->getFile($feedItem->post_filename); ?>" alt="img">
            <div class="col-md-12">
                <?php echo HtmlPurifier::process($feedItem->post_description); ?>
            </div>
            <div class="col-md-12">
                <?php echo Yii::$app->formatter->asDatetime($feedItem->post_created_at, "php:Y-d-m  H:i"); ?>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    <?php endforeach; ?>

<?php endif;?>

</div>
