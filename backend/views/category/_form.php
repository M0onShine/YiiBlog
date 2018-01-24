<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\CategoryDropDownList;

/* @var $this yii\web\View */
/* @var $model common\models\Meta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => 200]) ?>


    <?=CategoryDropDownList::widget([
        'model'=>$model,
        'attribute'=>'parent',
        'options'=>[
            'class'=>'form-control',
        ],
        'currentOptionDisabled'=>$model->isNewRecord?false:true
    ])?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => 200]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '增加分类' : '编辑分类', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
