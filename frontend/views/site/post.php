<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post common\models\Post */
$this->title = $post->title;
?>

<article class="post">

    <header class="post-head">
        <h1 class="post-title"><?=$post->title?></h1>
        <section class="post-meta">
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
        </section>
    </header>


    <section class="post-content">
        <?=\yii\helpers\Markdown::process($post->text)?>
    </section>

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

        <div class="pull-right share">

            </div>
    </footer>

</article>