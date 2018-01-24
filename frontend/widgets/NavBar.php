<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace frontend\widgets;

use common\models\Page;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class NavBar extends Widget{

    private $_htmlStr;

    public $options;

    public function init(){
        $pages=Page::find()->selectNoText()->published()->all();

        $this->_htmlStr='<ul class="menu">';
        $this->_htmlStr.='<li role="presentation" '.($this->active('site','index','')?'class="nav-current"':'').'>'.Html::a('首页',Url::home()).'</li>';
        if(!empty($pages)){
            foreach($pages as $page){
                $this->_htmlStr.='<li role="presentation" '.($this->active('site','page',$page->slug)?'class="nav-current"':'').'>'.Html::a($page->title,['site/page','slug'=>$page->slug,$this->options]).'</li>';
            }
        }
        $this->_htmlStr.='</ul>';
    }

    public function run(){
        return $this->_htmlStr;
    }

    protected function active($controllerId,$actionId,$slug){
        $currentControllerId=$this->view->context->id;
        $currentActionId=$this->view->context->action->id;
        $currentSlug=\Yii::$app->request->get('slug');

        $currentUrl=$currentControllerId.$currentActionId.$currentSlug;

        return $currentUrl==$controllerId.$actionId.$slug;
    }

}