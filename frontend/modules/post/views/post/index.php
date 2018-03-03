<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';

?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'format' => 'html',
                    'label' => Yii::t('my-profile', 'Image'),
                    'value' => function($data){
                        return Html::img($data->getImage(), ['width' => 200]);
                    },
            ],
            [
                'label' => Yii::t('my-profile', 'Description'),
                'value' => 'description',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
