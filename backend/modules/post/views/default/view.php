<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($post){
                    /** @var $post backend\models\Post */
                    return Html::img($post->getImage(),['width' =>900]);
                },
            ],
            'description:ntext',
            'created_at:datetime',
            'complaints',
        ],
    ]) ?>

</div>
