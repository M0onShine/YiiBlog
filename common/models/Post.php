<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\models;
use yii;
use common\helpers\StringHelper;
use yii\helpers\Html;

class Post extends Content{


    use AttachmentOperationTrait;

    const TYPE='post';

    public $inputCategories;

    public $inputTags;

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
                return '未命名文档';
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


    public function getCategories(){
        return $this->hasMany(Category::className(),['mid'=>'mid'])->where('type=:type',[':type'=>Category::TYPE])->viaTable(Relationship::tableName(),['cid'=>'cid']);

    }

    public function getTags(){
        return $this->hasMany(Tag::className(),['mid'=>'mid'])->where('type=:type',[':type'=>Tag::TYPE])->viaTable(Relationship::tableName(),['cid'=>'cid']);
    }

    public function deleteCategories($isCount=true){
        $existCategories=$this->categories;
        //删除关联
        foreach($existCategories as $v){
            Relationship::deleteAll(['cid'=>$this->cid,'mid'=>$v->mid]);
            //更新分类的文章数
            if($v->count>0&&$isCount){
                Category::updateAllCounters(['count'=>'-1'],['mid'=>$v->mid]);
            }
        }
    }

    public function insertCategories($categoryIds,$beforeCount=true,$afterCount=true){
        if(!is_array($categoryIds)){
            return false;
        }
        $categoryIds=array_unique($categoryIds);
        $this->deleteCategories($beforeCount);//先删除文章分类
        //插入新分类
        if($categoryIds){
            foreach($categoryIds as $v){
                if(!Category::find()->andWhere('mid=:mid',[':mid'=>$v])->one()){
                    continue;
                }
                $model=new Relationship();
                $model->cid=$this->cid;
                $model->mid=$v;
                $model->insert(false);
                if($afterCount){
                    //更新分类文章数
                    Category::updateAllCounters(['count'=>1],['mid'=>$v]);
                }
            }
        }
        return true;
    }

    public function deleteTags($isCount=true){
        //获取文章标签
        $existTags=$this->tags;
        //删除标签
        foreach($existTags as $v){
            Relationship::deleteAll(['cid'=>$this->cid,'mid'=>$v->mid]);
            //更新标签的文章数
            if($v->count>0&&$isCount){
                Tag::updateAllCounters(['count'=>'-1'],['mid'=>$v->mid]);
            }
        }
    }

    public function insertTags($tags,$beforeCount=true,$afterCount=true){

        if(!is_array($tags)){
            return false;
        }
        $this->deleteTags($beforeCount);//先删除标签
        //插入新标签
        $tagIds=Tag::scanTags($tags);
        if($tagIds){
            foreach($tagIds as $v){
                $model=new Relationship();
                $model->cid=$this->cid;
                $model->mid=$v;
                $model->insert(false);
                if($afterCount){
                    //更新标签文章数
                    Tag::updateAllCounters(['count'=>1],['mid'=>$v]);
                }
            }
        }

        return true;
    }

    public function afterSave($insert,$changedAttributes){
        parent::afterSave($insert,$changedAttributes);
        $beforeCount=$afterCount=false;
        if($insert){
            $beforeCount=false;
            $afterCount=$this->status==static::STATUS_PUBLISH;
        }else{
            if(isset($changedAttributes['status'])){
                $beforeCount=$changedAttributes['status']==static::STATUS_PUBLISH;
                $afterCount=$this->status==static::STATUS_PUBLISH;
            }
        }
        $this->insertCategories($this->inputCategories,$beforeCount,$afterCount);
        $this->insertTags($this->inputTags,$beforeCount,$afterCount);
        $this->insertAttachment($this->inputAttachments);
    }

    public function afterDelete(){
        parent::afterDelete();
        $this->deleteCategories($this->status==static::STATUS_PUBLISH);
        $this->deleteTags($this->status==static::STATUS_PUBLISH);
        $this->deleteAttachments();
    }

}