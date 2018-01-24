<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\widgets;

use common\components\CategoryTree;
use common\models\Post;
use yii;
use yii\helpers\Html;

class CategoryCheckboxList extends yii\base\Widget{

    public $postId;

    private $_inputStr;

    public $options;

    public function init(){

        parent::init();

        $this->options['encodeSpaces']=true;

        $postCategoryIds=[];
        if($this->postId!==null){
            $post=Post::find()->andwhere('cid=:cid',[':cid'=>$this->postId])->one();
            $postCategories=$post->getCategories()->asArray()->all();
            $postCategoryIds=yii\helpers\ArrayHelper::getColumn($postCategories,'mid');
        }

        $categories=CategoryTree::getInstance()->getAllCategories();

        $this->_inputStr='<div class="form-group">';

        $this->_inputStr.=Html::label('分类');
        if(!empty($categories)){
            foreach($categories as $v){

                $this->_inputStr.='<div class="checkbox">';
                $this->_inputStr.=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$v['depth']-1).Html::checkbox('inputCategories[]',in_array($v['mid'],$postCategoryIds),['label'=>$v['name'],'value'=>$v['mid']]);
                $this->_inputStr.='</div>';

            }
        }


        $this->_inputStr.='</div>';

    }

    public function run(){

        return $this->_inputStr;


    }
}