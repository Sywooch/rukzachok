<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Breadcrumbs;



$this->title = 'Редактирование профиля';
$this->params['breadcrumbs'][] = ['label'=>'Профиль','url'=>['/iam/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.mask.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\YiiAsset']]);

$this->registerJs("
$('#user-phone').mask('(000) 000-0000');
", View::POS_READY, 'mask');
?>
<nav class="bread-crumbs">
    <?= Breadcrumbs::widget([
        'links' => ['Мой кабинет'],
    ]) ?>
    <div class="both"></div>
</nav>
<div class="lay_title">
    <h1 class="uppercase center">Редактировать личные данные</h1>
</div>
<div class="layout">
    <div class="leftbar">
        <div class="mycabinet">
            <div class="begin">Мой кабинет</div>
            <ul>
                <li><a href="<?=Url::to(['iam/index'])?>">Личные данные</a></li>
                <li><a href="<?=Url::to(['iam/myorders'])?>">Мои заказы</a></li>
                <li><a href="<?=Url::to(['iam/share'])?>">Закладки</a></li>
                <!--li><a href="<?=Url::to(['iam/price'])?>">Пожелания</a></li-->
            </ul>
        </div>
    </div>

    <div class="content">

    <?php $form = ActiveForm::begin([
        'id' => 'reg-form',
        'options' => ['class' => 'form-vertical','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>


    <?= $form->field($model, 'password')->passwordInput() ?>
	
	<?= $form->field($model, 'password_repeat')->passwordInput(['value'=>$model->password]) ?>
	
	<?= $form->field($model, 'name') ?>
	
	<?= $form->field($model, 'surname') ?>
    
    <label class="control-label">Дата рождения</label>
    <div class="form-inline">    
        <? $day = [];
            for($i=1;$i<=31;$i++){
            $day[$i] = $i;
            }
            
            echo $form->field($model, 'birth_day')->dropDownList($day,['prompt'=>'День'])->label(false); 
            ?>

        <?          
            echo $form->field($model, 'birth_mouth')->dropDownList(['1'=>'Январь','2'=>'Февраль','3'=>'Март','4'=>'Апрель','5'=>'Май','6'=>'Июнь','7'=>'Июль','8'=>'Август','9'=>'Сентябрь','10'=>'Октябрь','11'=>'Ноябрь','12'=>'Декабрь'],['prompt'=>'Месяц'])->label(false); 
            ?>
            
            
        <? $year = [];
            for($i=date('Y');$i>=1920;$i--){
            $year[$i] = $i;
            }
            
            echo $form->field($model, 'birth_year')->dropDownList($year,['prompt'=>'Год'])->label(false); 
            ?>
            <div class="both"></div>
    </div><div class="both"></div>    
	<?= $form->field($model, 'phone') ?>
	
	<?=$form->field($model, 'sex')->dropDownList(['мужской' => 'мужской', 'женский' => 'женский'],['prompt'=>'...']); ?>

	
	<?= $form->field($model, 'body')->textArea(['rows' => '6']) ?>
	
	
	<?= $form->field($model, 'role')->hiddenInput(['value'=>'person'])->label(false); ?>
        <div>
            <center>

            <?= Html::submitButton(' Сохранить ', ['class' => 'submit4 bottom3', 'name' => 'login-button']) ?>

                </center>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
 