<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\assets;

use yii\web\AssetBundle;

class MomentAsset extends AssetBundle{

    public $sourcePath='@bower/moment';

    public $css = [

    ];
    public $js = [
        'min/moment.min.js',
        'locale/zh-cn.js'
    ];
    public $depends = [

    ];

}