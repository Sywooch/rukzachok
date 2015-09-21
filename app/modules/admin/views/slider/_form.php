<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['enctype' => 'multipart/form-data'],

    ]); ?>

    <?= $form->field($model, 'sort') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'image')->fileInput() ?>
        
    <?= $form->field($model, 'old_image')->hiddenInput(['value'=>$model->image])->label(false); ?>

    <?=$form->field($model, 'type')->dropDownList(['slider'=>'slider','banner_top'=>'banner_top'],['prompt'=>'...']); ?>


<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

