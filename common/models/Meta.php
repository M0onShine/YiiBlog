<?php

namespace common\models;

use common\helpers\StringHelper;
use common\queries\MetaQuery;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%metas}}".
 *
 * @property integer $mid
 * @property string $name
 * @property string $slug
 * @property string $type
 * @property string $description
 * @property integer $count
 * @property integer $order
 * @property integer $parent
 */
abstract class Meta extends \yii\db\ActiveRecord
{
    //const TYPE_CATEGORY='category';
    //const TYPE_TAG='tag';

    const TYPE='';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%metas}}';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mid' => 'Mid',
            'name' => '名称',
            'slug' => '缩略名',
            'type' => '类型',
            'description' => '描述',
            'count' => '文章数',
            'order' => '排序',
            'parent' => '父级',
        ];
    }


    /**
     * 检测生成缩略名
     * @param $attribute
     * @param $params
     */
    public function checkSlugName($attribute, $params){
        if (!$this->hasErrors()) {

            $name=StringHelper::generateCleanStr($this->$attribute);

            if(($attribute=='name'&&empty($name))||($attribute=='slug'&&!empty($this->slug)&&empty($name))){
                $this->addError($attribute, $this->getAttributeLabel($attribute).'全部为非法字符,无法转换');
            }

            if($attribute=='slug'&&empty($this->slug)){

                $this->$attribute=$this->name;
            }else{
                $this->$attribute=$name;
            }

        }
    }

    public function checkNameExist($attribute, $params){
        if (!$this->hasErrors()) {
            $model=self::findOne([$attribute=>$this->$attribute,'type'=>$this->type]);

            if($this->isNewRecord){
                if($model!=null){
                    $this->addError($attribute, $this->getAttributeLabel($attribute).'已经存在');

                }
            }else{
                if($model!=null&&$model->mid!=$this->mid){
                    $this->addError($attribute, $this->getAttributeLabel($attribute).'已经存在');

                }
            }

        }
    }

    public static function find(){
        return new MetaQuery(get_called_class(),['metaType'=>static::TYPE]);
    }
    public function getPosts($isPublished=true){

        $query= $this->hasMany(Post::className(),['cid'=>'cid'])->with('categories')->with('tags')->with('author')->orderByCid();
        if($isPublished){
            $query=$query->published();
        }
        return $query->viaTable(Relationship::tableName(),['mid'=>'mid']);


    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->type=static::TYPE;
            }
            return true;
        }else{
            return false;
        }

    }





}
