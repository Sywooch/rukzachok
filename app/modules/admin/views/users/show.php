<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\Progress;



$this->title = 'Профиль - Бычок';
$this->params['breadcrumbs'][] = 'Профиль';

?>
<div class="row">
  <div class="col-md-9">




<h1><?=Html::encode($model->name) . ' ' . Html::encode($model->surname);?></h1>
<label>Логин:</label> <?=Html::encode($model->username)?><br /> 
<label>Телефон:</label> <?=Html::encode($model->phone)?><br />
<label>Пол:</label> <?=Html::encode($model->sex)?><br /> 
<label>Возраст:</label> <?=$model->old;?> лет<br />  
<div class="block_info">О себе:</div>
<p><?=(!empty($model->body))?nl2br(Html::encode($model->body)):'Не заполненно!'?></p>
<?=Html::a('Редактировать профиль', ['/admin/users/save','id'=>$model->id], ['class'=>'btn btn-primary'])?>




</div>

</div>