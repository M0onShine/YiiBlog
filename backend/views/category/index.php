<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '管理分类';
?>
<div class="meta-index">

    <div class="btn-group">
        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
            选中项 <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#">删除</a></li>
            <li><a href="#">更新</a></li>
        </ul>

    </div>
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    <?php if($parentCategory): ?>
        <?= Html::a('返回上一级', ['/category','parent'=>$parentCategory->parent], ['class' => 'btn btn-default']) ?>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
            'name',
            [
                'header'=>'子分类',
                'class' => yii\grid\Column::className(),
                'content'=>function ($model, $key, $index, $column){
                    $count= \common\components\CategoryTree::getInstance()->getSubCategoriesCount($model->mid);
                    if($count==0){
                        return Html::a('新增',['/category/create','parent'=>$model->mid]);
                    }else{
                        return Html::a($count.'个分类',['/category','parent'=>$model->mid]);
                    }
                }
            ],
            'slug',

            'count',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
            ],
        ],
        'tableOptions'=>['class' => 'table table-striped']
    ]); ?>

</div>
