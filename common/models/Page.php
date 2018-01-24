<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\models;

use yii;
use common\helpers\StringHelper;
use yii\helpers\Html;

class Page extends Content{

    use AttachmentOperationTrait;

    const TYPE='page';
    public $inputAttachments;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'string', 'max' => 200],
            [['slug'],'filter','filter'=>function($value){
                return StringHelper::generateCleanStr($value);
            }],
            [['slug'], 'unique'],
            [['title'],'default','value'=>function($model,$attribute){
                return '未命名页面';
            }],
            [['title'],'filter','filter'=>function($value){
                return Html::encode($value);
            }],
            [['order','allowComment', 'allowPing', 'allowFeed'],'filter','filter'=>function($value){
                return intval($value);
            }],
            [['status'],'filter','filter'=>function($value){
                return in_array($value,[self::STATUS_PUBLISH,self::STATUS_HIDDEN])?$value:self::STATUS_PUBLISH;
            }],
            [['created'],'filter','filter'=>function($value){
                if($value==''){
                    return time();
                }else{
                    return strtotime($value);
                }
            }],
            [['text'],'safe'],

        ];
    }

    public function afterSave($insert,$changedAttributes){
        parent::afterSave($insert,$changedAttributes);
        $this->insertAttachment($this->inputAttachments);

    }

    public function afterDelete(){
        parent::afterDelete();
        $this->deleteAttachments();
    }

}