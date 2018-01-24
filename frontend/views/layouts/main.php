<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= \common\helpers\SiteHelper::getFrontendTitle($this->title) ?></title>

    <meta name="description" content="<?= \common\helpers\SiteHelper::getDescription($this->description) ?>" />
    <meta name="keywords" content="<?= \common\helpers\SiteHelper::getKeywords($this->keywords) ?>">
    <meta name="HandheldFriendly" content="True" />
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <?php $this->head() ?>
</head>
<body class="home-template">
    <?php $this->beginBody() ?>
    <!-- start header -->
    <header class="main-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <!-- start logo -->
                <a class="branding" href="<?=\yii\helpers\Url::home()?>" title="<?= \common\helpers\SiteHelper::getTitle() ?>"><img src="<?=\yii\helpers\Url::to('@web/image/logo.png')?>" alt="<?= \common\helpers\SiteHelper::getTitle() ?>"></a>
                <!-- end logo -->
                <h2 class="text-hide"><?= \common\helpers\SiteHelper::getDescription() ?></h2>
            </div>
        </div>
    </div>
    </header>
    <!-- end header -->

    <!-- start navigation -->
    <nav class="main-navigation">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="navbar-header">
                        <span class="nav-toggle-button collapsed" data-toggle="collapse" data-target="#main-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars"></i>
                        </span>
                    </div>
                    <div class="collapse navbar-collapse" id="main-menu">
                        <?=\frontend\widgets\NavBar::widget()?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- end navigation -->

    <!-- start site's main content area -->
    <section class="content-wrap">
    <div class="container">
    <div class="row">

    <main class="col-md-8 main-content">
        <?= $content ?>
    </main>

    <aside class="col-md-4 sidebar">

        <?=$this->render('/site/sidebar') ?>
        </aside>

    </div>
    </div>
    </section>

    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="widget">
                        <h4 class="title">最新文章</h4>
                        <div class="content recent-post">
                            <?=\frontend\widgets\NewPosts::widget()?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="widget">
                        <h4 class="title">标签云</h4>
                        <div class="content tag-cloud">
                            <?=\frontend\widgets\TagCloud::widget() ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="widget">
                        <h4 class="title">合作伙伴</h4>
                        <div class="content tag-cloud friend-links">
                            <a href="https://coding.net" target="_blank">Coding</a>
                            <a href="https://github.com" target="_blank">Github</a>

                        </div>
                    </div></div>
            </div>
        </div>
    </footer>

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <span>Copyright &copy; <?=Yii::$app->name;?> <?= date('Y') ?></span> |
                    <span><?=Yii::powered()?></span>
                </div>
            </div>
        </div>
    </div>

    <a href="#" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
