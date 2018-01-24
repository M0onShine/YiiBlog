<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理文件';
?>
<div class="content-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
            [
                'attribute'=>'title',
                'format'=>'html',
                'value'=>function($model){
                    return Html::a($model->title,$model->path,['target'=>'_blank']);
                },
            ],
            [
                'attribute'=>'authorId',
                'value'=>function($model){
                    return $model->author==null?'-':$model->author->screenName;
                },
            ],
            [
                'attribute'=>'parent',
                'format'=>'html',
                'value'=>function($model){
                    $value='-';
                    if($model->post!=null){
                        $value=Html::a($model->post->title,['post/update','id'=>$model->post->cid]);
                    }elseif($model->page!=null){
                        $value=Html::a($model->page->title,['post/update','id'=>$model->page->cid]);
                    }
                    return $value;
                },
            ],
            [
                'label'=>'文件大小',
                'value'=>function($model){
                    return Yii::$app->formatter->asShortSize($model->size);
                },
            ],
            'created:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',
            ],
        ],
        'tableOptions'=>['class' => 'table table-striped']
    ]); ?>

</div>
