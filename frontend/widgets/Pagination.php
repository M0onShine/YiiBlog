<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace frontend\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

class Pagination extends Widget{

    private $_htmlStr;

    private $_pageCount;

    private $_currentPage;

    public $pagination;

    public $nextPageLabel='<i class="fa fa-angle-right"></i>';

    public $prevPageLabel='<i class="fa fa-angle-left"></i>';

    public function init(){

        if ($this->pagination === null) {
            throw new InvalidConfigException('The "pagination" property must be set.');
        }

        $this->_pageCount= $this->pagination->getPageCount();
        $this->_currentPage = $this->pagination->getPage();

        $this->_htmlStr='<nav class="pagination" role="navigation">
        <a class="newer-posts" href="/"><i class="fa fa-angle-left"></i></a>
    <span class="page-number">第 2 页 ⁄ 共 7 页</span>
        <a class="older-posts" href="/page/3/"><i class="fa fa-angle-right"></i></a>
</nav>';


    }

    public function run(){

        $this->_htmlStr='<nav class="pagination" role="navigation">';
        $this->_htmlStr.=$this->renderPrevButton();
        $this->_htmlStr.=Html::tag('span',sprintf('第 %d 页 ⁄ 共 %d 页',$this->_currentPage+1,$this->_pageCount),['class'=>'page-number']);
        $this->_htmlStr.=$this->renderNextButton();
        $this->_htmlStr.='</nav>';

        return $this->_htmlStr;

    }

    protected function renderPrevButton(){
        if (($page = $this->_currentPage - 1) < 0) {
            $page = 0;
        }
        if($this->_currentPage>0){
            return Html::a($this->prevPageLabel, $this->pagination->createUrl($page), ['class'=>'newer-posts']);
        }
        return '';
    }

    protected function renderNextButton(){
        if (($page = $this->_currentPage + 1) >= $this->_pageCount - 1) {
            $page = $this->_pageCount - 1;
        }
        if($this->_currentPage < $this->_pageCount - 1){
            return Html::a($this->nextPageLabel, $this->pagination->createUrl($page), ['class'=>'older-posts']);
        }
        return '';
    }

}