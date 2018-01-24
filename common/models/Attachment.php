<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\models;

use yii\helpers\Html;

class Attachment extends Content{

    const TYPE='attachment';

    const SAVE_PATH='@webroot/upload/';
    const WEB_URL='@web/upload/';

    private $_path;
    private $_ext;
    private $_minetype;
    private $_name;
    private $_size;

    public static $imageMineType=['image/jpeg','image/png','image/bmp','image/gif'];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'title' => '文件名',
            'slug' => '缩略名',
            'created' => '发布日期',
            'modified' => '修改日期',
            'text' => '内容',
            'authorId' => '上传者',
            'parent' => '所属文章',
        ];
    }

    public function getPath(){
        if(!$this->_path){
            $this->_path=self::parseAttachmentContent($this->text,'path');
        }
        return $this->_path;
    }

    public function getExt(){
        if(!$this->_ext){
            $this->_ext=self::parseAttachmentContent($this->text,'ext');
        }
        return $this->_ext;
    }

    public function getMinetype(){
        if(!$this->_minetype){
            $this->_minetype=self::parseAttachmentContent($this->text,'minetype');
        }
        return $this->_minetype;
    }
    public function getName(){
        if(!$this->_name){
            $this->_name=self::parseAttachmentContent($this->text,'name');
        }
        return $this->_name;
    }
    public function getSize(){
        if(!$this->_size){
            $this->_size=self::parseAttachmentContent($this->text,'size');
        }
        return $this->_size;
    }


    public static  function parseAttachmentContent($jsonContent,$key){
        $attachmentContent=json_decode($jsonContent,true);
        return $attachmentContent[$key];
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->created=time();
                $this->slug=\common\helpers\StringHelper::generateCleanStr($this->title).'-'.sha1(microtime(true));
                $this->title=Html::encode($this->title);
                $this->text=json_encode($this->text);
            }
            return true;
        }else{
            return false;
        }

    }

    public function getPost(){
        return $this->hasOne(Post::className(),['cid'=>'parent']);
    }
    public function getPage(){
        return $this->hasOne(Page::className(),['cid'=>'parent']);
    }

    public function afterDelete(){
        parent::afterDelete();
        unlink(\Yii::getAlias('@webroot'.$this->path));
    }



}