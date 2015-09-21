<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\components\ckeditor\CKEditor;
use app\mihaildev\elfinder\ElFinder;
use app\modules\admin\models\Catalog;
use app\modules\admin\models\Filters;
?>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['enctype' => 'multipart/form-data'],

    ]); ?>

    <?= $form->field($model, 'catalog_id')->hiddenInput(['value'=>$_GET['catID']])->label(false); ?>    

    <?= $form->field($model, 'parent_id')
     ->dropDownList(
            ArrayHelper::map(Filters::find()->where(['parent_id'=>0])->all(), 'id', 'name'),['prompt'=>'Группа фильтров']
            )?>
    <?= $form->field($model, 'name') ?>

       
        


    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

