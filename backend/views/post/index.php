<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Content */

$this->title = '文章';
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
                    return $model->title.'&nbsp;'.Html::a('<span class="glyphicon glyphicon-link"></span>',Yii::$app->frontendUrlManager->createUrl(['site/post','id'=>$key]),['target'=>'_blank','title'=>'查看']);
                }
            ],
            [
                'attribute'=>'authorId',
                'value'=>function($model){
                    return $model->author==null?'-':$model->author->screenName;
                },
            ],
            [
                'label'=>'分类',
                'value'=>function($model){
                    $names= ArrayHelper::getColumn(ArrayHelper::toArray($model->categories),'name');
                    return implode(' ',$names);
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
