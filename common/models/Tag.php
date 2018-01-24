<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\models;

use common\helpers\StringHelper;

class Tag extends Meta{

    const TYPE='tag';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name','slug'],'checkSlugName','skipOnEmpty'=>false],
            [['name','slug'],'checkNameExist','skipOnEmpty'=>false],
            [['name', 'slug', 'description'], 'string', 'max' => 200],
        ];
    }

    public function afterDelete(){
        parent::afterDelete();
        //删除和文章的关联
        Relationship::deleteAll(['mid'=>$this->mid]);
    }

    //根据tag获取id
    public static function scanTags($inputTags){
        if(!is_array($inputTags)){
            return false;
        }
        $inputTags=array_unique($inputTags);
        $result=[];
        foreach($inputTags as $v){
            if(empty($v)){
                continue;
            }
            $slug=StringHelper::generateCleanStr($v);
            if(!$slug){
                continue;
            }
            $model=static::find()->andWhere(['name'=>$slug])->one();
            if($model){
                $result[]=$model->mid;

            }else{
                $tag=new self();
                $tag->name=$tag->slug=$slug;
                if($tag->insert(false)){
                    $result[]=$tag->mid;
                }
            }

        }
        return $result;
    }






}