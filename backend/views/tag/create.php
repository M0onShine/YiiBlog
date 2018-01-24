<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Meta */

$this->title = '新增标签';
?>
<div class="meta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
