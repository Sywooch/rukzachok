<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['class' => 'form-vertical'],

    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'url') ?>

	<?= $form->field($model, 'sort') ?>


    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

