<?php

namespace common\models;

use common\helpers\StringHelper;
use common\queries\ContentQuery;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%contents}}".
 *
 * @property integer $cid
 * @property string $title
 * @property string $slug
 * @property integer $created
 * @property integer $modified
 * @property string $text
 * @property integer $order
 * @property integer $authorId
 * @property string $template
 * @property string $type
 * @property string $status
 * @property string $password
 * @property integer $commentsNum
 * @property string $allowComment
 * @property string $allowPing
 * @property string $allowFeed
 * @property integer $parent
 */
abstract class Content extends \yii\db\ActiveRecord
{

    //const TYPE_POST='post';
    //const TYPE_PAGE='page';
    //const TYPE_ATTACHMENT='attachment';

    const STATUS_PUBLISH='publish';
    const STATUS_HIDDEN='hidden';

    const TYPE='';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contents}}';
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'title' => '标题',
            'slug' => '缩略名',
            'created' => '发布日期',
            'modified' => '修改日期',
            'text' => '内容',
            'order' => '页面顺序',
            'authorId' => '作者',
            'template' => '模板',
            'type' => '类型',
            'status' => '公开度',
            'password' => '密码',
            'commentsNum' => '评论数',
            'allowComment' => '允许评论',
            'allowPing' => '允许被引用',
            'allowFeed' => '允许在聚合中出现',
            'parent' => '所属文章',
        ];
    }
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){

            if($insert){

                $this->authorId=Yii::$app->user->identity->getId();
                $this->type=static::TYPE;
            }

            $this->modified=time();

            return true;
        }else{
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert,$changedAttributes);
        //更新slug
        if(trim($this->slug)==''){
            $this->slug=$this->cid;
            Content::updateAll(['slug'=>$this->cid],['cid'=>$this->cid]);
        }
    }

    public static function find(){
        return new ContentQuery(get_called_class(),['contentType'=>static::TYPE]);
    }

    public function getAuthor(){
        return $this->hasOne(User::className(),['uid'=>'authorId']);
    }

}
