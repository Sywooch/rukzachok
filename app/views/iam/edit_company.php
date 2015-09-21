<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;



$this->title = 'Редактирование Исполнителя - Компании';
$this->params['breadcrumbs'][] = ['label'=>'Профиль','url'=>['/iam/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.mask.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\YiiAsset']]);

$this->registerJs("
$('#user-phone').mask('(000) 000-0000');
", View::POS_READY, 'mask');
?>
<div class="col-md-6 col-md-offset-3">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'reg-form',
        'options' => ['class' => 'form-vertical','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'company') ?>
    
    <?= $form->field($model, 'password')->passwordInput() ?>
	
	<?= $form->field($model, 'password_repeat')->passwordInput(['value'=>$model->password]) ?>
	
	<?= $form->field($model, 'name') ?>
	
	<?= $form->field($model, 'surname') ?>
    
    
	

	<?= $form->field($model, 'body')->textArea(['rows' => '6']) ?>
	
    <?= $form->field($model, 'image')->fileInput() ?>
        
    <?= $form->field($model, 'old_image')->hiddenInput(['value'=>$model->image])->label(false); ?> 	
	
	<?= $form->field($model, 'role')->hiddenInput(['value'=>'company'])->label(false); ?> 
    <div class="form-group">
            <?= Html::submitButton(' Сохранить ', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 