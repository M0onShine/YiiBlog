<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\widgets;

use common\components\CategoryTree;
use yii;
use yii\helpers\Html;

class CategoryDropDownList extends yii\bootstrap\Widget{

    public $model;
    public $attribute;
    public $options=[];

    public $currentOptionDisabled=false;//当前选项是否禁止选择


    private $_categories=[];

    private $_inputStr;


    public function init(){

        parent::init();

        $this->options['encodeSpaces']=true;
        $this->options['prompt']='不选择';

        $categories=CategoryTree::getInstance()->getAllCategories();
        if(!empty($categories)){
            foreach($categories as $v){
                $tempArr=[];
                $tempArr[$v['mid']]=str_repeat('    ',$v['depth']-1).$v['name'];
                $this->_categories+=$tempArr;

                if($this->currentOptionDisabled){
                    $model=$this->model;
                    $this->options['options'][$model->mid]=['disabled' => true];
                }

            }
        }


        $this->_inputStr='<div class="form-group">';

        $this->_inputStr.=Html::activeLabel($this->model,$this->attribute);

        $this->_inputStr.=Html::activeDropDownList($this->model,$this->attribute,$this->_categories,$this->options);

        $this->_inputStr.='</div>';


    }

    public function run(){


        return $this->_inputStr;


    }
}