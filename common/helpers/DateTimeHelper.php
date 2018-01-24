<?php
namespace common\helpers;

use yii;
class DateTimeHelper{

    public static function getYear($timestamp){
      return  Yii::$app->formatter->asDate($timestamp,'yyyy');
    }

    public static function getMonth($timestamp){
        return  Yii::$app->formatter->asDate($timestamp,'MM');
    }

    public static function getDay($timestamp){
        return  Yii::$app->formatter->asDate($timestamp,'dd');
    }

}