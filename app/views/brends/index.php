<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Бренды';
$this->registerMetaTag(['name' => 'description', 'content' => 'Бренды']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Бренды']);

$this->params['breadcrumbs'][] = ['label'=>'Бренды','url'=>['/brends/index']];
?>

            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
            ]) 
        
        ?>
                            <div class="both"></div>
            </nav>


<div class="loyout">
    
    <h1>Бренды</h1>
    
    <ul class="brends_list">
       <?foreach($brends as $item):?>
       <li>
           
	<a href="<?=Url::to(['brends/show','translit'=>$item->translit])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/brends/'.$item->image?>" width="150" height="150" border="0" /></a>
	<br />
        <a href="<?=Url::to(['brends/show','translit'=>$item->translit])?>" class="name"><?=$item->name?></a>
           
           
       </li>
       <?endforeach;?><div class="both"></div>
    </ul>    
    
</div>
