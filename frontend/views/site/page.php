<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = $page->title;
?>

<article class="post page">

    <header class="post-head">
        <h1 class="post-title"><?=$page->title ?></h1>
    </header>

    <section class="post-content">
        <?=\yii\helpers\Markdown::process($page->text)?>
    </section>

</article>
