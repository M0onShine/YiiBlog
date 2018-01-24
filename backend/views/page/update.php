<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = '编辑: ' . ' ' . $model->title;
?>
<div class="content-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
