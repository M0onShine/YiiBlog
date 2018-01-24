<?php
/* @var $this yii\web\View */
/* @var $post common\models\Content */

$this->title = '网站概要';
?>
<div class="row">
    <div class="col-lg-12">

        <div class="panel panel-default">
            <div class="panel-body">
                <p class="lead">目前有 <em><?=$postCount?></em> 篇文章, 并有 <em>0</em> 条关于你的评论在 <em><?=$categoryCount?></em> 个分类中.</p>
                <p class="lead">点击下面的链接快速开始:</p>
                <div>

                    <?=\yii\helpers\Html::a('撰写新文章',['/post/create'],['class'=>'btn btn-primary'])?>
                    <?=\yii\helpers\Html::a('系统设置',['/option'],['class'=>'btn btn-primary'])?>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">最近发布的文章</h3>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <?php foreach($recentPublishedPost as $post): ?>
                    <li>
                        <span class="pull-right"><?=Yii::$app->formatter->asDate($post->created,'MM.dd') ?></span>
                        <?=\yii\helpers\Html::a($post->title,Yii::$app->frontendUrlManager->createUrl(['site/post','id'=>$post->cid]),['target'=>'_blank'])?>
                    </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">最近得到的回复</h3>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li>todo</li>

                </ul>
            </div>
        </div>
    </div>
</div>