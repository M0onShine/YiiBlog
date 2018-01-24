<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\assets;

use yii\web\AssetBundle;

class Markdown2HtmlAsset extends AssetBundle{

    public $sourcePath='@npm/markdown';

    public $css = [

    ];
    public $js = [
        'lib/markdown.js',
    ];
    public $depends = [

    ];

}