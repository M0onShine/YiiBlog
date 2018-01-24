<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
$this->title = '管理标签';
?>
<div class="meta-index">

    <p>
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
            'name',
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
