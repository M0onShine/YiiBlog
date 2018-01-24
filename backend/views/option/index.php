<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OptionGeneralForm */
/* @var $form ActiveForm */
$this->title='基本设置';
?>
<div class="option-general">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'keywords') ?>
    
        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- option-general -->
