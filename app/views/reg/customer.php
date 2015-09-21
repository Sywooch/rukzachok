<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;



$this->title = 'Регистрация Заказчика';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.mask.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\YiiAsset']]);

$this->registerJs("
$('#user-phone').mask('(000) 000-0000');
", View::POS_READY, 'mask');
?>
<div class="col-md-6 col-md-offset-3">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info">Потратив пару минут для регистрации на Бычок, вы сможете создавать заказы и находить исполнителей.</div>

    <?php $form = ActiveForm::begin([
        'id' => 'reg-form',
        'options' => ['class' => 'form-vertical'],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
	
	<?= $form->field($model, 'password_repeat')->passwordInput() ?>
	
	<?= $form->field($model, 'name') ?>
	
	<?= $form->field($model, 'surname') ?>
	
	<?= $form->field($model, 'phone') ?>
	
	<?= $form->field($model, 'verifyCode')->widget(Captcha::className(),['captchaAction'=>'reg/captcha']) ?>

	<?= $form->field($model, 'role')->hiddenInput(['value'=>'customer'])->label(false); ?> 
    <div class="form-group">
            <?= Html::submitButton(' Регистрация ', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 