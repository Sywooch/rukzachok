<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\Progress;



$this->title = 'Профиль - Бычок';
$this->params['breadcrumbs'][] = 'Профиль';

?>
<div class="row">
  <div class="col-md-9">



<div class="block_photo">
<img src="<?=Yii::$app->request->baseUrl?>/upload/profile/ico/<?=$model->imageProfile?>" width="240" height="240" class="img-thumbnail" align="left" />
<?if($model->time_online>time()):?><span class="label label-success pull-right">online</span><?endif;?>

<h1><?=Html::encode($model->company)?></h1>
<label>Имя:</label> <?=Html::encode($model->name) . ' ' . Html::encode($model->surname);?><br />
<label>Логин:</label> <?=Html::encode($model->username)?><br /> 
<label>Телефон:</label> <?=Html::encode($model->phone)?><br />


<?=Html::a('Редактировать профиль', ['/iam/edit'], ['class'=>'btn btn-primary'])?>
&nbsp;
<?=Html::a('Создать услугу', ['/myservice/save'], ['class'=>'btn btn-success'])?>
<div class="both"></div>
</div>
<?
$p = 0;
if(!empty($model->username))$p +=20;
if(!empty($model->name))$p +=20;
if(!empty($model->phone))$p +=20;
if(!empty($model->company))$p +=20;


if(!empty($model->body))$p +=20;
echo 'Ваш профиль заполнен на '.round($p).'%:';
echo Progress::widget([
    'percent' => round($p),
    'barOptions' => ['class' => 'progress-bar-success'],
    'options' => ['class' => 'progress-striped','style'=>'width:400px;']
]);?>


<div class="block_info">О компании:</div>
<p><?=(!empty($model->body))?nl2br(Html::encode($model->body)):'Не заполненно!'?></p>


</div>
  <div class="col-md-3">
	<?if($model->active==0):?>
	<div class="alert alert-danger">Ваш Профиль пока не проверен Бычком!</div>
	<?else:?>
	<div class="alert alert-success">Поздравляем!<br />Ваш Профиль проверен Бычком!</div>
	<?endif;?>
	<?=Html::a('Создать услугу', ['/myservice/save'], ['class'=>'btn btn-success btn-lg btn-block'])?>
	<?=Html::a('Ваши услуги', ['/myservice'], ['class'=>'btn btn-default btn-lg btn-block'])?>
  
  
  </div>
</div>
