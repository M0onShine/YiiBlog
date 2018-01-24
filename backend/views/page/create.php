<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = '创建新页面';
?>
<div class="content-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
