<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\queries;

use common\models\Content;
use yii\db\ActiveQuery;

class ContentQuery extends ActiveQuery{

    public $contentType;

    public function init(){
        parent::init();
        $this->type($this->contentType);

    }

    public function selectNoText(){

        $columns=array_keys(Content::getTableSchema()->columns);

        $key=array_search('text',$columns);

        if($key!==false){
            unset($columns[$key]);
        }
        $this->select($columns);
        return $this;
    }

    public function type($type){
        $this->andWhere(['type'=>$type]);
        return $this;
    }

    public function published(){
        $this->andWhere(['status'=>Content::STATUS_PUBLISH]);
        return $this;
    }

    public function recentPublished($limit=10){
        $this->andWhere(['status'=>Content::STATUS_PUBLISH]);
        $this->limit($limit);
        $this->orderBy(['cid'=>SORT_DESC]);
        return $this;
    }

    public function orderByCid(){
        $this->orderBy(['cid'=>SORT_DESC]);
        return $this;
    }


}