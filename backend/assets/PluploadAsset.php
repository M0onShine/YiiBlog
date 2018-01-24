<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace backend\assets;

use yii\web\AssetBundle;

class PluploadAsset extends AssetBundle{

    public $sourcePath='@vendor/moxiecode/plupload';

    public $css = [

    ];
    public $js = [
        'js/plupload.full.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}