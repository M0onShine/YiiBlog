<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Meta */

$this->title = '新增分类';
?>
<div class="meta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
