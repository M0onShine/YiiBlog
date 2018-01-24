<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\assets;

use yii\web\AssetBundle;

class BootstrapMarkdownAsset extends AssetBundle{

    public $sourcePath='@npm/bootstrap-markdown';

    public $css = [
        'css/bootstrap-markdown.min.css',
    ];
    public $js = [
        'js/bootstrap-markdown.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'backend\assets\Markdown2HtmlAsset',
    ];

}