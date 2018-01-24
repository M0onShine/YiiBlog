<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\models;

use yii\helpers\Html;

class Category extends Meta{

    const TYPE='category';

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
            [['description'],'filter','filter'=>function($value){
                return Html::encode($value);
            }],
            [['parent'],'filter','filter'=>function($value){
                $value=intval($value);
                if($value!=0){
                    $parent=self::find()->where('mid=:mid',[':mid'=>$value])->one();
                    return $parent?$value:0;
                }
                return 0;

            }],
        ];
    }

    public function afterDelete(){
        parent::afterDelete();
        //修改直接子类的父级id
        self::updateAll(['parent'=>$this->parent],'parent=:parent AND type=:type',[':parent'=>$this->mid,':type'=>static::TYPE]);
        //删除和文章的关联
        Relationship::deleteAll(['mid'=>$this->mid]);

    }


}