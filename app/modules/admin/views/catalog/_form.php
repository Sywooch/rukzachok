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

<?= $form->field($model, 'parent_id')->dropDownList(
      ArrayHelper::map(Catalog::find()->where('parent_id=0')->orderBy('id')->all(), 'id', 'name'),['prompt'=>'Корневой раздел','value'=>0]) ?>

    <?= $form->field($model, 'sort') ?>

    <?= $form->field($model, 'name') ?>

    <? /*$form->field($model, 'translit', [
            'addon' => ['prepend' => ['content'=>'@']]
        ]);*/?>
    <?= $form->field($model, 'translit',[
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">catalog/</span>{input}</div>',
    ]);?>
        
    <?= $form->field($model, 'image')->fileInput() ?>
        
    <?= $form->field($model, 'old_image')->hiddenInput(['value'=>$model->image])->label(false); ?>    

    <?=$form->field($model, 'body')->widget(CKEditor::className(),[
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */]),
    ]);
    ?>

    <?= $form->field($model, 'meta_title') ?>

    <?= $form->field($model, 'meta_keywords') ?>

    <?= $form->field($model, 'meta_description') ?>


    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

