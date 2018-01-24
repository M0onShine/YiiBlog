<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = '撰写新文章';
?>
<div class="content-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
