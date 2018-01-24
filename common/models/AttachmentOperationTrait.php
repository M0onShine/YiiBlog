<?php
namespace common\models;
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
trait AttachmentOperationTrait{

    public function getAttachments(){
        return $this->hasMany(Attachment::className(),['parent'=>'cid']);
    }

    public function insertAttachment($attachmentIds){
        if(!is_array($attachmentIds)){
            return false;
        }
        $attachmentIds=array_unique($attachmentIds);
        foreach($attachmentIds as $v){
            $model=Attachment::find()->andWhere(['cid'=>$v])->one();
            if(!$model||$model->parent!=0){
                continue;
            }
            $model->parent=$this->cid;
            $model->update(false);
        }
        return true;
    }

    public function deleteAttachments(){
        $attachments=$this->attachments;
        foreach($attachments as $attachment){
            $attachment->delete();
        }
    }
}