<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\widgets;

use common\components\MediaComp;
use common\models\Attachment;
use yii;

class Plupload extends yii\base\Widget{


    public $serverUrl;

    public $fileInputName;

    public $filesInputHiddenName;

    public $attachments;

    private $_html;

    public function init(){

        if(!$this->fileInputName){
            $this->fileInputName='file';
        }
        if(!$this->filesInputHiddenName){
            $this->filesInputHiddenName='file[]';
        }

        if(!$this->serverUrl){
            throw new yii\base\InvalidConfigException('serverUrl属性必须设置');
        }

        $this->_html='
<div class="panel panel-default">
  <div class="panel-body">
<a id="pickfiles" href="javascript:;">选择文件上传</a>
  </div>
</div>
<ul class="list-group" id="file-list">
';

        if($this->attachments){
            foreach($this->attachments as $v){
                $this->_html.='<li class="list-group-item" id="'.$v->cid.'"><span class="glyphicon glyphicon-remove pull-right" aria-hidden="true"></span><input type="hidden" name="'.$this->filesInputHiddenName.'" value="'.$v->cid.'"><a href="javascript:;" title="点击插入图片到编辑器" data-url="'.$v->path.'" data-image="'.in_array($v->minetype,Attachment::$imageMineType).'">'.$v->title.'</a></li>';
            }
        }
        $this->_html.='</ul>';
    }


    public function run(){

        $this->view->registerAssetBundle('\backend\assets\PluploadAsset');

        $this->view->registerJs('

        var uploader = new plupload.Uploader({
	runtimes : "html5",
	browse_button : "pickfiles",
	file_data_name:"'.$this->fileInputName.'",
	//container: document.getElementById("container"),
	url : "'.$this->serverUrl.'",
	filters : {
		max_file_size : "10mb",
		mime_types: [{"title" : "允许上传的文件", "extensions" : "gif,jpg,jpeg,png,tiff,bmp,mp3,wmv,wma,rmvb,rm,avi,flv,txt,doc,docx,xls,xlsx,ppt,pptx,zip,rar,pdf"}],
        prevent_duplicates  :   true
	},
	multipart_params:{
        '.Yii::$app->request->csrfParam.':"'.Yii::$app->request->getCsrfToken().'"
	},

	init: {

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {

			    $("#file-list").append(\'<li class="list-group-item" id="\'+file.id+\'"><span class="pull-right" aria-hidden="true"></span>\'+file.name+\'</li>\');
			});

			uploader.start();
		},

		UploadProgress: function(up, file) {
		    $("#"+file.id).find("span").text(file.percent+"%");
		},

		FileUploaded:function (up, file, result) {
                    if (200 == result.status) {
                        var response = $.parseJSON(result.response);
                        if (response.err==0) {
                            var data=response.data;
                            $("#"+file.id).html(\'<span class="glyphicon glyphicon-remove pull-right" aria-hidden="true"></span><input type="hidden" name="'.$this->filesInputHiddenName.'" value="\'+data.id+\'"/><a href="javascript:;" title="点击插入图片到编辑器" data-url="\'+data.url+\'" data-image="\'+data.isImage+\'">\'+data.name+\'</a>\');
                            bindInsertFileToEditor();
                        }else{
                            alert(response.msg);
                            //清除
                            $("#"+file.id).remove();
                        }
                    }
        },

		Error: function(up, err) {
                alert(err.code+":"+err.message);
		}
	}
});


function bindInsertFileToEditor(){

    $("#file-list li a").bind("click", function() {
        var isImage=$(this).data("image");
        var url=$(this).data("url");
        var title=$(this).text();

        var html=\'[\'+title+\'](\'+url+\' "\'+title+\'")\';
        if(isImage){
            html=\'!\'+html;
        }
        $("#markdown-textarea").data("markdown").replaceSelection(html);
    });
}



uploader.init();
bindInsertFileToEditor();

        ');

        return $this->_html;
    }

}