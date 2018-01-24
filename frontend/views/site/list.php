<?php
use yii\helpers\Html;
use common\helpers\DateTimeHelper;
/* @var $this yii\web\View */
/* @var $pagination yii\data\Pagination */
$this->title = '';
?>
<?php if(isset($category)):?>
    <?php $this->title='分类'.$category->name.'下的文章' ?>
<div class="cover tag-cover">
    <h3 class="tag-name">
        分类：<?=$category->name ?>
    </h3>
    <div class="post-count">
        共 <?=$pagination->totalCount ?> 篇文章
    </div>
</div>
<?php endif; ?>

<?php if(isset($tag)):?>
    <?php $this->title='标签'.$tag->name.'下的文章' ?>
    <div class="cover tag-cover">
        <h3 class="tag-name">
            标签：<?=$tag->name ?>
        </h3>
        <div class="post-count">
            共 <?=$pagination->totalCount ?> 篇文章
        </div>
    </div>
<?php endif; ?>

<?php if(isset($author)):?>
    <?php $this->title=$author->screenName.'发布的文章' ?>
    <div class="cover tag-cover">
        <h3 class="tag-name">
            作者：<?=$author->screenName ?>
        </h3>
        <div class="post-count">
            共 <?=$pagination->totalCount ?> 篇文章
        </div>
    </div>
<?php endif; ?>

<?php foreach($posts as $post): ?>
<article class="post">

    <div class="post-head">
        <h1 class="post-title"><?=Html::a($post->title,['post','id'=>$post->cid])?></h1>
        <div class="post-meta">
            <span class="author"><i class="fa fa-user"></i> <?=Html::a($post->author==null?'':$post->author->screenName,['site/author','name'=>$post->author->name])?></span> &bull;
            <span><i class="fa fa-clock-o"></i> <time class="date" datetime="<?=Yii::$app->formatter->asDate($post->created)?>"><?=Yii::$app->formatter->asDate($post->created)?></time></span> &bull;
            <span>
            <i class="fa fa-folder-open-o"></i>
            <?php
            $postCategories=$post->categories;
            foreach($postCategories as $v):
                ?>
                <?=Html::a($v->name,['site/category','slug'=>$v->slug])?>
            <?php endforeach; ?>
            </span>
        </div>
    </div>
    <div class="post-content">
        <?=\yii\helpers\Markdown::process($post->text)?>
    </div>
    <div class="post-permalink">
        <?=Html::a('阅读原文',['post','id'=>$post->cid],['class'=>'btn btn-default'])?>
    </div>

    <footer class="post-footer clearfix">
        <div class="pull-left tag-list">
            <i class="fa fa-tag"></i>
            <?php
            $postTags=$post->tags;
            foreach($postTags as $v):
                ?>
                <?=Html::a($v->name,['site/tag','slug'=>$v->slug])?>
            <?php endforeach; ?>
        </div>
    </footer>
</article>
<?php endforeach; ?>

<?=\frontend\widgets\Pagination::widget(['pagination'=>$pagination])?>