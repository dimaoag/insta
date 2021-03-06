<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */
/* @var $currentUser frontend\models\User */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm */
/* @var $posts frontend\models\Post */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\modules\user\models\forms\PictureForm;
use dosamigos\fileupload\FileUpload;
use yii\web\YiiAsset;

$this->title = Html::encode($user->username);
?>


<div class="page-posts no-padding">
    <div class="row">
        <div class="page page-post col-sm-12 col-xs-12 post-82">
            <div class="blog-posts blog-posts-large">
                <div class="row">
                    <!-- profile -->
                    <article class="profile col-sm-12 col-xs-12">
                        <div class="profile-title">
                            <img src="<?php echo $user->getPicture(); ?>" id="profile-picture" class="author-image" />
                            <div class="author-name"><?php echo Html::encode($user->username); ?></div>

                            <?php if ($currentUser): ?>

                                <?php if ($currentUser->equals($user)): ?>


                                    <?= FileUpload::widget([
                                        'model' => $modelPicture,
                                        'attribute' => 'picture',
                                        'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
                                        'options' => ['accept' => 'image/*'],
                                        'clientEvents' => [
                                            'fileuploaddone' => 'function(e, data) {
                                                if(data.result.success){
                                                    $("#profile-image-success").show();
                                                    $("#profile-image-fail").hide();
                                                    $("#profile-picture").attr("src", data.result.pictureUri);
                                                } else {
                                                    $("#profile-image-fail").html(data.result.errors.picture).show();
                                                    $("#profile-image-success").hide();
                                                    }
                                                }',],
                                        ]);
                                    ?>

                                    <a href="<?php echo Url::to(['/user/profile/delete-picture']); ?>" class="btn btn-danger"><?=Yii::t('my-profile', 'Delete picture') ?></a>
                                    <a href="<?php echo Url::to(['/user/profile/edit']); ?>" class="btn btn-default"><?=Yii::t('my-profile', 'Edit profile') ?></a>
                                    <a href="<?php echo Url::to(['/post/post/index']); ?>" class="btn btn-default"><?=Yii::t('my-profile', 'Edit posts') ?></a>

                                <?php endif; ?>
                            <?php endif; ?>

                            <hr>
                            <div class="alert alert-success display-none" id="profile-image-success"><?=Yii::t('my-profile', 'Profile image updated') ?></div>
                            <div class="alert alert-danger display-none" id="profile-image-fail"></div>
                        </div>
                        <?php if ($currentUser && !$user->equals($currentUser)): ?>
                            <?php if (!$currentUser->isFollowing($user)): ?>
                                <a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>" class="btn btn-info"><?=Yii::t('my-profile', 'Subscribe') ?></a>
                            <?php else: ?>
                                <a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>" class="btn btn-info"><?=Yii::t('my-profile', 'Unsubscribe') ?></a>
                            <?php endif; ?>
                            <?php if ($mutualSubscriptions = $currentUser->getMutualSubscriptionsTo($user)): ?>
                                <hr>
                                <h5><?=Yii::t('my-profile', 'Friends, who are also following') ?> <?php echo Html::encode($user->username); ?>: </h5>
                                <div class="row">
                                    <?php foreach ($mutualSubscriptions as $item): ?>
                                        <div class="col-md-12">
                                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]); ?>">
                                                <?php echo Html::encode($item['username']); ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($user->about): ?>
                            <div class="profile-description">
                                <p><?php echo HtmlPurifier::process($user->about); ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="profile-bottom">
                            <div class="profile-post-count">
                                <span><?php echo $user->getPostCount(); ?> <?=Yii::t('my-profile', 'Posts') ?></span>
                            </div>
                            <div class="profile-followers">
                                <a href="#" data-toggle="modal" data-target="#myModal1">
                                    <?php echo $user->countSubscriptions(); ?> <?=Yii::t('my-profile', 'Subscriptions') ?>
                                </a>
                            </div>
                            <div class="profile-following">
                                <a href="#" data-toggle="modal" data-target="#myModal2">
                                    <?php echo $user->countFollowers(); ?> <?=Yii::t('my-profile', 'Followers') ?>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php if ($posts = $user->getPosts()): ?>
                        <div class="col-sm-12 col-xs-12">
                            <div class="row profile-posts">
                                <?php foreach ($posts as $post) :?>
                                    <div class="col-md-4 profile-post">
                                        <a href="<?php echo Url::to(['/post/'.$post->id])?>">
                                            <img src="<?php echo Yii::$app->storage->getFile($post->filename); ?>" class="author-image" />
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal subscriptions -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?=Yii::t('my-profile', 'Subscriptions') ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getSubscriptions() as $subscription): ?>
                        <div class="col-md-12">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? $subscription['nickname'] : $subscription['id']]); ?>">
                                <?php echo Html::encode($subscription['username']); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('my-profile', 'Close') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal subscriptions -->

<!-- Modal followers -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?=Yii::t('my-profile', 'Followers') ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getFollowers() as $follower): ?>
                        <div class="col-md-12">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?>">
                                <?php echo Html::encode($follower['username']); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('my-profile', 'Close') ?></button>
            </div>
        </div>
    </div>
</div>



<!-- Modal followers -->


<?php
$this->registerJsFile('@web/js/like4.js', [
    'depends' => YiiAsset::className(),
]);

?>