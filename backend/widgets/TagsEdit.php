<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace backend\widgets;

use common\components\TagComp;
use yii;

class TagsEdit extends yii\base\Widget{



    public $name;

    public $tags;

    private $_html;

    public function init(){

        if(trim($this->name)==''){
            throw new yii\base\InvalidConfigException();
        }

        $this->_html='<div class="form-group">
<label for="" class="control-label">标签[回车添加]</label>
<div id="tag-list">';

        if($this->tags){
            foreach($this->tags as $v){
                $this->_html.='<div class="label label-default">
<input name="'.$this->name.'" type="hidden" value="'.$v->name.'"/>
'.$v->name.'<span class="glyphicon glyphicon-remove"></span></div>';
            }
        }

        $this->_html.='</div>';

        $this->_html.=yii\helpers\Html::textInput('add-tag',null,['class'=>'form-control','id'=>'add-tag']);

        $this->_html.='</div>';


    }

    public function run(){

        $this->view->registerJs('

        bindRemoveTag();


        $(document).keydown(function(event){

if(event.keyCode==13){

if(event.target.id=="add-tag"){

var val=$.trim($("#add-tag").val());

$("#add-tag").val("");
if(val==""){
    return false;
}

var exist=false;
$("input[name=\''.$this->name.'\']").each(function(){
    if(val==$(this).val()){
        exist=true;
        return false;

    }
});

if(exist){
    return false;
}
$("#tag-list").append(\'<div class="label label-default"><input name="'.$this->name.'" type="hidden" value="\'+val+\'"/>\'+val+\'<span class="glyphicon glyphicon-remove"></span></div>\');

bindRemoveTag();
return false;

}

}

});


function bindRemoveTag(){

$("#tag-list .glyphicon-remove").bind("click", function() {
    $(this).parent().remove();
});

}
        ');

        return $this->_html;
    }

}