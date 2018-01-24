<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace frontend\widgets;

use common\models\Post;
use yii\base\Widget;
use yii\helpers\Html;

class NewPosts extends Widget{

    private $_htmlStr;


    public function init(){

        $newPosts=Post::find()->selectNoText()->recentPublished(3)->all();
        foreach($newPosts as $post){
            $this->_htmlStr.=Html::tag('div',Html::a($post->title,['site/post','id'=>$post->cid],['class'=>'post-title']).Html::tag('div',\Yii::$app->formatter->asDate($post->created),['class'=>'date']),['class'=>'recent-single-post']);
        }
    }

    public function run(){
        return $this->_htmlStr;
    }

}