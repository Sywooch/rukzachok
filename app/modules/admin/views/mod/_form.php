<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\components\ckeditor\CKEditor;
use app\mihaildev\elfinder\ElFinder;
use app\modules\admin\models\Catalog;
?>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['enctype' => 'multipart/form-data'],

    ]); ?>


    <?= $form->field($model, 'active')->radioList([0=>'есть',1=>'нет']) ?>

    <?= $form->field($model, 'product_id')->hiddenInput(['value'=>$_GET['productID']])->label(false); ?>    

    <?= $form->field($model, 'art') ?>

    <?= $form->field($model, 'name') ?>

       
    <?= $form->field($model, 'cost') ?>

    <?= $form->field($model, 'old_cost') ?>
        
    <?= $form->field($model, 'image')->fileInput() ?>
        
    <?= $form->field($model, 'old_image')->hiddenInput(['value'=>$model->image])->label(false); ?>    
       

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

