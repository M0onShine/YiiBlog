<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\widgets;

use yii;
use yii\helpers\Html;
use common\components\User;

class UserGroupDropDownList extends yii\bootstrap\Widget{

    public $model;
    public $attribute;
    public $options=[];


    private $_inputStr;


    public function init(){

        parent::init();

        $this->_inputStr='<div class="form-group">';

        $this->_inputStr.=Html::activeLabel($this->model,$this->attribute);

        $this->_inputStr.=Html::activeDropDownList($this->model,$this->attribute,\common\models\User::getUserGroup(),$this->options);

        $this->_inputStr.='</div>';


    }

    public function run(){


        return $this->_inputStr;


    }
}