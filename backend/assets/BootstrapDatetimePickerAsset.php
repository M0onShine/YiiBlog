<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\assets;

use yii;
use yii\web\AssetBundle;

class BootstrapDatetimePickerAsset extends AssetBundle{



    public $sourcePath='@bower/eonasdan-bootstrap-datetimepicker';

    public $css = [
        'build/css/bootstrap-datetimepicker.min.css',
    ];
    public $js = [
        'build/js/bootstrap-datetimepicker.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'backend\assets\MomentAsset',
    ];

}