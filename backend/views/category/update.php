<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Meta */

$this->title = '编辑分类: ' . ' ' . $model->name;
?>
<div class="meta-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
