<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace frontend\widgets;

use common\models\Tag;
use yii\base\Widget;
use yii\helpers\Html;

class TagCloud extends Widget{

    private $_htmlStr;

    public $options;

    public function init(){
        parent::init();

        $tags=Tag::find()->orderByCount()->all();

        if(!empty($tags)){
            foreach($tags as $v){
                $this->_htmlStr.=Html::a($v->name,['site/tag','slug'=>$v->slug],$this->options);

            }
        }

    }

    public function run(){
        return $this->_htmlStr;
    }

}