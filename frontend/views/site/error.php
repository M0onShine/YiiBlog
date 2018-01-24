<?php
use yii\helpers\Html;
/* @var $exception \yii\web\HttpException|\Exception */
/* @var $handler \yii\web\ErrorHandler */
$message='不好意思出错啦';
if ($exception instanceof \yii\web\HttpException) {
    $code = $exception->statusCode;
    switch($code){
        case 404 :$message='页面不存在或已经删除';break;
        case 500 :$message='服务器内部错误';break;
        default:$message='不好意思出错啦';
    }
} else {
    $code = $exception->getCode();
}
?>
<!doctype html>
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if (gte IE 9)| IEMobile |!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>404 — 页面未找到</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <link rel="shortcut icon" href="favicon.ico">
    <meta http-equiv="cleartype" content="on">

    <link rel="stylesheet" href="<?=\yii\helpers\Url::to('@web/css/all.css') ?>" />
</head>
<body class="">
<main role="main" id="main">
    <div id="container">
        <section class="error-content error-404 js-error-container">
            <section class="error-details">
                <figure class="error-image">
                    <img
                        class="error-ghost"
                        src="<?=\yii\helpers\Url::to('@web/image/404-ghost@2x.png')?>"
                        srcset="<?=\yii\helpers\Url::to('@web/image/404-ghost.png')?> 1x, <?=\yii\helpers\Url::to('@web/image/404-ghost@2x.png')?> 2x"/>
                </figure>
                <section class="error-message">
                    <h1 class="error-code"><?=Html::encode($code) ?></h1>
                    <h2 class="error-description"><?=Html::encode($message) ?></h2>
                    <a class="error-link" href="<?=\yii\helpers\Url::home()?>">返回首页 →</a>
                </section>
            </section>
        </section>
    </div>
</main>
</body>
</html>
