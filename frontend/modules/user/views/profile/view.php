<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */
/* @var $currentUser frontend\models\User */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\modules\user\models\forms\PictureForm;
use dosamigos\fileupload\FileUpload;
use yii\web\YiiAsset;

?>

<h3 class="name"><?php echo Html::encode($user->username); ?></h3>
<p><?php echo HtmlPurifier::process($user->about); ?></p>
<hr>

<img src="<?php echo $user->getPicture(); ?>" id="profile-picture">



<?php if ($currentUser): ?>

    <?php if ($currentUser->equals($user)): ?>
        <hr>
        <div class="alert alert-success display-none" id="profile-image-success">Profile image updated</div>
        <div class="alert alert-danger display-none" id="profile-image-fail"></div>


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
                                        
                }',
            ],
        ]); ?>

        <a href="<?php echo Url::to(['/user/profile/delete-picture']); ?>" class="btn btn-danger">Delete picture</a>

    <?php endif; ?>
<?php endif; ?>
<hr>

<?php if ($currentUser && !$user->equals($currentUser)): ?>

    <?php if (!$currentUser->isFollowing($user)): ?>
        <a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Subscribe</a>
    <?php else: ?>
        <a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Unsubscribe</a>
    <?php endif; ?>

    <?php if ($mutualSubscriptions = $currentUser->getMutualSubscriptionsTo($user)): ?>
        <hr>
        <h5>Friends, who are also following <?php echo Html::encode($user->username); ?>: </h5>
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

<hr>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">
    Subscriptions: (<?php echo $user->countSubscriptions(); ?>)
</button>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal2">
    Followers: (<?php echo $user->countFollowers(); ?>)
</button>


<div class="container">
    <h1 style="text-align: center;  ">My Posts</h1>
    <div class="site-index">
        <?php if ($feedItems): ?>

            <?php foreach ($feedItems as $feedItem) :?>

                <div class="col-md-12">
                    <div class="col-md-12">
                        <img src="<?= $user->getPicture(); ?>" alt="img" style="width: 30px; height: 30px">
                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' =>($user->nickname) ? $user->nickname : $user->id]); ?>">
                            <?php echo Html::encode($user->username); ?>
                        </a>
                    </div>
                    <a href="<?php echo Url::to(['/post/'.$feedItem->id])?>">
                        <img src="<?php echo Yii::$app->storage->getFile($feedItem->filename); ?>" alt="img">
                    </a>
                    <div class="col-md-12">
                        <?php echo HtmlPurifier::process($feedItem->description); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo Yii::$app->formatter->asDatetime($feedItem->created_at, "php:Y-d-m  H:i"); ?>
                    </div>
                    <div class="col-md-12">
                        Likes: <small class="likes-count"><?php $user->likesPost($feedItem->id); ?></small>

                        <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser->likesPost($feedItem->id)) ? "" : "display-none"; ?>" data-id="<?php echo $feedItem->id; ?>">
                            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                        </a>
                        <a href="#" class="btn btn-primary button-like <?php echo ($currentUser->likesPost($feedItem->id)) ? "display-none" : ""; ?>" data-id="<?php echo $feedItem->id; ?>">
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
</div>




<!-- Modal subscriptions -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Subscriptions</h4>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <h4 class="modal-title" id="myModalLabel">Followers</h4>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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