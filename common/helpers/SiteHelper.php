<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\helpers;

use common\models\Option;
use yii;
class SiteHelper{

    public static function getBackendTitle($title){
        return $title?$title.'-'.Yii::$app->name:Yii::$app->name;
    }
    public static function getFrontendTitle($title){
        return $title?$title.'-'.self::getTitle():self::getTitle();
    }
    public static function getFrontendKeywords($keywords){
        return $keywords.','.self::getKeywords();
    }
    public static function getFrontendDescription($description){
        return $description.','.self::getDescription();
    }
    public static function getTitle(){
        return Option::getOptionValue('title');
    }
    public static function getKeywords(){
        return Option::getOptionValue('keywords');
    }
    public static function getDescription(){
        return Option::getOptionValue('description');
    }

}