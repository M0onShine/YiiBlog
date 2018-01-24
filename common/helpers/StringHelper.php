<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\helpers;

use yii\helpers\Markdown;
use yii\helpers\VarDumper;
class StringHelper{

    /**
     * 过滤生成只包含字母数字下划线横线的字符串
     * @param $str
     * @return string
     */
    public static function generateCleanStr($str){
        if(empty($str)){
            return '';
        }
        $str=trim(strtolower($str));
        $str=preg_replace('/[^\w_-]/u','-',$str);

        return trim($str,'-_');

    }

    //检测干净的字符串
    public static function checkCleanStr($str){

        if(preg_match('/[^\w_-]/u',$str)){
            return false;
        }else{
            return true;
        }
    }

    public static function markdown2html($str){
        return Markdown::process($str);
    }

    public static function dump($var,$depth=10){

        VarDumper::dump($var,$depth,true);
    }

}