<!-- start widget -->
<div class="widget">
    <h4 class="title">下载 MoBlog</h4>
    <div class="content download">
        <a href="https://coding.net/u/mojifan/p/MoBlog/git" target="_blank" class="btn btn-default btn-block">去Coding下载</a>
        <a href="https://github.com/mojifan/MoBlog" target="_blank" class="btn btn-default btn-block">去Github下载</a>
    </div>
</div>
<!-- end widget -->
<div class="widget">
    <h4 class="title">分类</h4>
    <div class="content category">
        <?=\common\widgets\CategoryList::widget()?>
    </div>
</div>
<!-- start tag cloud widget -->
<div class="widget">
    <h4 class="title">标签云</h4>
    <div class="content tag-cloud">
        <?=\frontend\widgets\TagCloud::widget() ?>
    </div>
</div>