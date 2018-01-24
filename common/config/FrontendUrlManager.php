<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules'=>[
        '/'=>'site/index',
        'post/<id:\d+>'=>'site/post',
        'page/<slug:[\w-]+>'=>'site/page',
        'category/<slug:[\w-]+>'=>'site/category',
        'tag/<slug:[\w-]+>'=>'site/tag',
        'author/<name:[\w-]+>'=>'site/author',
    ],
];