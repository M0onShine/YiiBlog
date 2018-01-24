<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\widgets;

use yii;
use yii\base\Widget;
use yii\base\Model;

use yii\helpers\Html;
class BootstrapDatetimePicker extends Widget{



    public $model;

    public $attribute;

    public $name='datetime';
    public $value;

    public $options;

    public $locale='zh-cn';

    public $dateFormat='YYYY-MM-DD HH:mm';

    private $_inputStr;

    public function init(){

        parent::init();


        $this->_inputStr='<div class="form-group">';

        if($this->hasModel()){
            $this->_inputStr.=Html::activeLabel($this->model,$this->attribute);
        }else{
            $this->_inputStr.=Html::label($this->name);
        }
        $this->_inputStr.='<div id="'.Html::encode($this->name).'" class="input-group date">';

        if ($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $value = $this->value;
        }
        if ($value !== null) {
            $value = Yii::$app->formatter->asDatetime($value);
        }


        $options=$this->options;
        $options['class']='form-control';
        //$options['readonly'] = '';
        $options['value'] = $value;

        if($this->hasModel()){
            $this->_inputStr.=Html::activeTextInput($this->model,$this->attribute,$options);
        }else{
            $this->_inputStr.=Html::textInput($this->name,$this->value,$options);
        }

        $this->_inputStr.='<span class="input-group-addon">
                                        <span class="glyphicon-calendar glyphicon"></span>
                                    </span>
                                </div>
                                </div>
                                ';


    }


    public function run(){
        $view=$this->getView();
        \backend\assets\BootstrapDatetimePickerAsset::register($view);
        $jsStr='$("#'.Html::encode($this->name).'").datetimepicker({locale:"'.Html::encode($this->locale).'",format:"'.$this->dateFormat.'"});';
        $view->registerJs($jsStr);

        return $this->_inputStr;
    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }


}