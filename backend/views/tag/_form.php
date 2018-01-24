<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Meta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => 200]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '增加标签' : '编辑标签', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
