<?
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;


$this->title = 'Мои заказы';
$this->params['breadcrumbs'][] = $this->title;

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
		<h1 class="uppercase center">Мои заказы</h1>
	</div>
	<div class="layout">
	<div class="leftbar">
		<div class="mycabinet">
			<div class="begin">Мой кабинет</div>
            <ul>
                <li><a href="<?=Url::to(['iam/index'])?>">Личные данные</a></li>
                <li><a href="<?=Url::to(['iam/myorders'])?>" class="active">Мои заказы</a></li>
                <li><a href="<?=Url::to(['iam/share'])?>">Закладки</a></li>
                <!--li><a href="<?=Url::to(['iam/price'])?>">Пожелания</a></li-->
            </ul>
		</div>
	</div>

	<div class="content">


        <div class="favorites">
            <div style="margin-top:-5px;">
               <?foreach($model as $item):?>
                <div class="fav_point">
                    <div class="left"><a href="#" class="link">№ <?=$item->id?></a></div>
                    <div class="left"><?=$item->date_time?></div>
                    <div class="left">на <?=$item->total?> грн</div>
                    <div class="right redtext"><?=$item->status?></div>
                    <div class="both"></div>

                    <div class="orders_view">
                   <?foreach($item->products as $item_p):if(!empty($item_p->cost)):?>
                        <div class="order">
                            <div class="pixbox"><?if(!empty($item_p->mod->imageAvator)):?><img width="120" src="<?=Yii::$app->request->baseUrl.'/upload/mod/big/'.$item_p->mod->imageAvator?>"><?endif;?></div>
                            <div class="order_title"><?=$item_p->product_name?></div>
                            <div class="order_count">Кол-во: <?=$item_p->count?></div>
                            <div class="order_price"><span><?=$item_p->cost?></span> грн.</div>
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
