<?php
/**
 * @var $this yii\web\View;
 * @var $users[] frontend\models\User;
 * @var $user frontend\models\User;
 * @var $pagination yii\data\Pagination;
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;


$this->title = 'All Users';

?>


<div class="page-posts no-padding">
    <div class="row">
        <div class="page page-post col-sm-12 col-xs-12">
            <div class="blog-posts blog-posts-large">

                <div class="row">
                    <!-- feed item -->

                    <?php foreach ($users as $user) :?>

                    <article class="post col-sm-12 col-xs-12">
                        <div class="post-meta">
                            <div class="post-title">
                                <a href="<?php echo Url::to(['/user/profile/view', 'nickname' =>($user->nickname) ? $user->nickname : $user->id]); ?>">
                                    <img src="<?= $user->getPicture(); ?>" class="author-image" />
                                </a>
                                <div class="author-name">
                                    <a href="<?php echo Url::to(['/user/profile/view', 'nickname' =>($user->nickname) ? $user->nickname : $user->id]); ?>">
                                        <?php echo Html::encode($user->username); ?>
                                    </a>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php echo LinkPager::widget(['pagination' => $pagination]); ?>
            </div>
        </div>
    </div>
</div>