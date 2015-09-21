<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

$this->title = 'Мои закладки';
$this->registerMetaTag(['name' => 'description', 'content' => 'Мои закладки']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Мои закладки']);

$this->registerJs("

    $('.orders_view').hide();
    $('.fav_point .link').click(function(){
        $(this).parent().parent().find('.orders_view').toggle();
        return false;
    });

", View::POS_READY, 'orders_view');
?>
<nav class="bread-crumbs">
	<?= Breadcrumbs::widget([
		'links' => ['Мой кабинет'],
	]) ?>
	<div class="both"></div>
</nav>
<div class="lay_title">
	<h1 class="uppercase center">Мои закладки</h1>
</div>
<div class="layout">
	<div class="leftbar">
		<div class="mycabinet">
			<div class="begin">Мой кабинет</div>
			<ul>
				<li><a href="<?=Url::to(['iam/index'])?>">Личные данные</a></li>
				<li><a href="<?=Url::to(['iam/myorders'])?>">Мои заказы</a></li>
				<li><a href="<?=Url::to(['iam/share'])?>" class="active">Закладки</a></li>
				<!--li><a href="<?=Url::to(['iam/price'])?>">Пожелания</a></li-->
			</ul>
		</div>
	</div>

	<div class="content">


		<div class="favorites">
			<div style="margin-top:-5px;">
				<?foreach($share as $key=>$item):?>
					<div class="fav_point">
						<div class="left"><a href="#" class="link">№ <?=$key+1?></a></div>
						<div class="left"><?=$item->date?></div>
						<div class="both"></div>

						<div class="orders_view">
							<?foreach($item->shareList as $item_p):if(!empty($item_p->product)):?>
								<div class="order">
									<div><a href="<?=Url::to(['iam/share','deleteID'=>$item_p->id])?>" class="delete_button"></a></div>
									<div class="pixbox"><a href="<?=Url::to(['products/show','translit_rubric'=>$item_p->product->catalog->translit,'translit'=>$item_p->product->translit,'id'=>$item_p->product->id])?>"><img width="120" src="<?=Yii::$app->request->baseUrl.'/upload/products/ico/'.$item_p->product->imageAvator?>"></a></div>
									<div class="order_title"><a href="<?=Url::to(['products/show','translit_rubric'=>$item_p->product->catalog->translit,'translit'=>$item_p->product->translit,'id'=>$item_p->product->id])?>" class="name"><?=$item_p->product->name?></a></div>
									<?if(!empty($item_p->product->cost->cost)):?><div class="order_price"><span><?=$item_p->product->cost->cost?></span> грн.</div><?endif;?>
									<p class="note"></p>
								</div>
							<?endif;endforeach;?>
							<div class="both"></div>
						</div>
					</div>
				<?endforeach;?>

			</div>

		</div>






	</div>
</div>
