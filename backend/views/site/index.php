<?php

/* @var $this yii\web\View */


use yii\helpers\Url;
use frontend\components\Debug;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Adminka</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Manage Complaints</h2>

                <p><a class="btn btn-default" href="<?= Url::to(['/complaints/manage']) ?>">Manage Complaints</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Manage Posts</h2>

                <p><a class="btn btn-default" href="<?= Url::to(['/post/default/index']) ?>">Manage Posts</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Manage Users</h2>

                <p><a class="btn btn-default" href="<?= Url::to(['/user/manage']) ?>">Manage Users</a></p>
            </div>
        </div>


    </div>
</div>
