<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\queries;

use yii\db\ActiveQuery;

class MetaQuery extends ActiveQuery{


    public $metaType;

    public function init(){
        parent::init();
        $this->type($this->metaType);
    }

    public function type($type){
        $this->andWhere(['type'=>$type]);
        return $this;
    }

    public function orderByMid(){
        $this->orderBy(['mid'=>SORT_DESC]);
        return $this;
    }
    public function orderByCount(){
        $this->orderBy(['count'=>SORT_DESC]);
        return $this;
    }
}