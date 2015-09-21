<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'СРАВНЕНИЕ';
$this->registerMetaTag(['name' => 'description', 'content' => 'СРАВНЕНИЕ']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'СРАВНЕНИЕ']);

$this->params['breadcrumbs'][] = ['label'=>'Каталог','url'=>['/catalog/all']];
$this->params['breadcrumbs'][] = ['label'=>'СРАВНЕНИЕ','url'=>['/products/compare']];
?>


            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
            ]) ?>
            <div class="both"></div>
            </nav>


		<h1>СРАВНЕНИЕ</h1>
		<div class="products pn">
		
			<ul>
				
                                <?foreach($products as $item):?>
                                <li class="item">
					<a href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/products/ico/'.$item->image?>" width="134" height="200" border="0" /></a>
					<strong><a href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id])?>" class="name"><?=$item->name?></a></strong>
						<div class="info">
                                                    <p>Бренд: <?=$item->brend->name?></p>
						<?foreach($item->params as $key=>$param):?>
                                                    <p><?=$param->name?> <?=$param->size?></p>
                                                <?endforeach;?>
						</div>
                                        <p class="cost"><?=$item->cost->cost?> грн.</p>
					<a href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id])?>" class="link_buy">Купить</a>
	
                                </li>
                                <?endforeach;?>
                                
			</ul><div class="both"></div>
		</div>

