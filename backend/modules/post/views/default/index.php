<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'format' => 'raw', //без изменений
                'value' => function($post){
                    /** @var $post backend\models\Post */
                    return Html::a($post->id,['view', 'id' => $post->id]);
                },
            ],
            'user_id',
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($post){
                    /** @var $post backend\models\Post */
                    return Html::img($post->getImage(),['width' =>150]);
                },
            ],
            'description:ntext',
            'created_at:datetime',
            'complaints',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} &nbsp;&nbsp; {delete}',
            ],
        ],
    ]); ?>
</div>
