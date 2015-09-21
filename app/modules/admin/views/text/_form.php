<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\ckeditor\CKEditor;
use app\mihaildev\elfinder\ElFinder;

?>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['class' => 'form-vertical'],

    ]); ?>

    <?= $form->field($model, 'title') ?>

    <? /*$form->field($model, 'translit', [
            'addon' => ['prepend' => ['content'=>'@']]
        ]);*/?>
    <?= $form->field($model, 'translit',[
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">text/</span>{input}</div>',
    ]);?>

    <?=$form->field($model, 'body')->widget(CKEditor::className(),[
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */]),
    ]);
    ?>

    <?= $form->field($model, 'meta_title') ?>

    <?= $form->field($model, 'meta_keywords') ?>

    <?= $form->field($model, 'meta_description') ?>


    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

