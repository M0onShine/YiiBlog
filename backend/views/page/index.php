<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '独立页面';
?>
<div class="content-index">

    <p>
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
            [
                'header'=>'标题',
                'class' => yii\grid\Column::className(),
                'content'=>function ($model, $key, $index, $column){
                    return $model->title.'&nbsp;'.Html::a('<span class="glyphicon glyphicon-link"></span>',Yii::$app->frontendUrlManager->createUrl(['site/page','slug'=>$model->slug]),['target'=>'_blank','title'=>'查看']);
                }
            ],
            'slug',
            [
                'attribute'=>'authorId',
                'value'=>function($model){
                    return $model->author==null?'-':$model->author->screenName;
                },
            ],
            'created:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
            ],
        ],
        'tableOptions'=>['class' => 'table table-striped']
    ]); ?>

</div>
