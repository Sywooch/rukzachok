<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\components\ckeditor\CKEditor;
use app\mihaildev\elfinder\ElFinder;
use app\modules\admin\models\Catalog;
use app\modules\admin\models\Filters;
use app\modules\admin\models\Type;
use app\modules\admin\models\Brends;
?>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['enctype' => 'multipart/form-data'],

    ]); ?>

    <?= $form->field($model, 'catalog_id')->hiddenInput(['value'=>$_GET['catID']])->label(false); ?>    
    <?= $form->field($model, 'catalog_parent_id')->hiddenInput(['value'=>$_GET['catParentID']])->label(false); ?>    
    <?= $form->field($model, 'brend_id')
        ->dropDownList(ArrayHelper::map(Brends::find()->asArray()->orderBy('name')->all(), 'id', 'name'),['prompt'=>'...'])
    ?>
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'translit',[
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">products/</span>{input}</div>',
    ]);?>
        
    <?= $form->field($model, 'image')->fileInput() ?>
        
    <?= $form->field($model, 'old_image')->hiddenInput(['value'=>$model->image])->label(false); ?>    

    <?=$form->field($model, 'body_ru')->widget(CKEditor::className(),[
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */]),
    ]);
    ?>

    <?= $form->field($model, 'params')->textarea() ?>

    <?//=$form->field($model, 'char')->widget(CKEditor::className(),[
   // 'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */]),
   // ]);
    ?>

    <?= $form->field($model, 'new')->checkbox() ?>

    <?= $form->field($model, 'top')->checkbox() ?>

    <?= $form->field($model, 'akciya')->checkbox() ?>

    <? 
    
    	foreach(Filters::find()->with(['childs'])->where(['parent_id'=>0])->orderby(['id'=>'asc'])->all() as $row){
	 foreach($row->childs as $child){
	  $data[] = ['id'=>$child->id,'value'=>$child->name,'group'=>$row->name];
	 }
	}
    echo $form->field($model, 'filters')
        ->dropDownList(ArrayHelper::map($data, 'id', 'value','group'), ['multiple' => true])
    ?>

    <?= $form->field($model, 'type')
        ->dropDownList(ArrayHelper::map(Type::find()->where(['catalog_id'=>$_GET['catID']])->asArray()->orderBy('name')->all(), 'id', 'name'), ['multiple' => true])
    ?>


    <?= $form->field($model, 'meta_title') ?>

    <?= $form->field($model, 'meta_keywords') ?>

    <?= $form->field($model, 'meta_description') ?>


    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

