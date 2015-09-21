<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Забыли пароль?';
$this->registerMetaTag(['name' => 'description', 'content' => 'Забыли пароль?']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Забыли пароль?']);

?>


<div class="col-md-6 col-md-offset-3">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Если Вы по каким то причинам забыли свой пароль, то введите пожалуйста свой логин. После чего Вам на почтовый ящик прейдет письмо с вашим паролем.</p>

<?if($flash = Yii::$app->session->getFlash('success')):?>
    <div class="alert-success"><?=$flash?></div>
<?endif; ?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'well form-vertical'],
        'enableClientScript' => false,
    ]); ?>

    <?= $form->field($model, 'username') ?>


    <?= Html::submitButton('Получить пароль', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>



    <?php ActiveForm::end(); ?>

</div>