<?php
use yii\helpers\Html;
use yii\web\View;
use app\models\Slider;
use yii\helpers\Url;
use app\components\Text;

$this->title = $text->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $text->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $text->meta_keywords]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/slides.min.jquery.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJs(" 
                        $('#slides').slides({
                                preload: true,
                                play: 5000,
                                pause: 2500,
                                hoverPause: true
                        });
", View::POS_READY, 'slider');
$this->registerCssFile(Yii::$app->request->BaseUrl.'/js/jsor-jcarousel-7bb2e0a/skins/tango/skin.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jsor-jcarousel-7bb2e0a/lib/jquery.jcarousel.min.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJs("

    jQuery('.jcarousel').jcarousel({
        vertical: true,
        scroll: 2
    });

", View::POS_READY, 'jcarousel');
?>

		<div class="slider">
		    <div class="banner">
			<div id="slides">
                <div class="slides_container">
					<?php foreach(Slider::find()->orderBy('sort')->all() as $item):?>
                                        <div class="slide">
<a href="<?=$item->url?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/slider/'.$item->image?>" width="720" height="340" border="0" /></a>
					</div>
					<?php endforeach;?>					
				</div>
                                <a href="#" class="prev"><img src="img/arrow-prev.png" width="25" height="39" border="0" alt="Arrow Prev"></a>
                                <a href="#" class="next"><img src="img/arrow-next.png" width="25" height="39" border="0" alt="Arrow Next"></a>
			</div>	
			<div class="sub">
				<a href="<?=Url::to(['products/index','translit'=>'ryukzaki','filters'=>'40'])?>"><img src="img/man_sub.jpg" width="238" height="104" border="0" /></a>
				<a href="<?=Url::to(['products/index','translit'=>'ryukzaki','filters'=>'42'])?>"><img src="img/woman_sub.jpg" width="238" height="104" border="0" /></a>
				<a href="<?=Url::to(['products/index','translit'=>'ryukzaki','filters'=>'86'])?>"><img src="img/children_sub.jpg" width="238" height="104" border="0" /></a>
			</div>
			</div>
			<div class="fl">
				<img src="img/banner1.jpg" width="220" height="447" border="0" />
			</div><div class="both"></div>
		</div>

		<div class="rubrics">
			<ul>
				<li class="item1"><a href="<?=Url::to(['products/index','translit'=>'ryukzaki'])?>">Рюкзаки</a></li>
				<li class="item2"><a href="<?=Url::to(['products/index','translit'=>'sumki'])?>">сумки</a></li>
				<li class="item3"><a href="<?=Url::to(['products/index','translit'=>'chehly'])?>">чехлы</a></li>
				<li class="item4"><a href="<?=Url::to(['products/index','translit'=>'nesessery'])?>">Несессеры</a></li>
				<li class="item5"><a href="<?=Url::to(['products/index','translit'=>'koshelki'])?>">кошельки</a></li>
			</ul><div class="both"></div>
		</div>


<?php if(count($products_top)>0):?>
		<div class="products">
		<h3>Топ товары</h3>
			<ul>
                                                      
			<?php foreach($products_top as $item):?>	
                            <li class="item">
                                <?= $this->render('/products/_product',['item'=>$item,'num'=>4]) ?>
				</li>
                            <?php endforeach;?>     
				
			</ul><div class="both"></div>
		</div>
<?php endif; ?>


		<div class="products">
		<h3>Скидки</h3>
			<ul>
			<?php foreach($products_new as $item):?>	
                            <li class="item">
				<?= $this->render('/products/_product',['item'=>$item,'num'=>4]) ?>
				</li>
                            <?php endforeach;?> 
                        </ul><div class="both"></div>
		</div>




		<h2 class="why"><span>Почему</span></h2>
		<ul class="why_list">
			<li class="item1">
				<span>Только брендовые товары.</span> Мы не торгуем подделками — только проверенное качество.
			</li>
			<li class="item2">
				<span>Скидки постоянным клиентам.</span> Постоянные клиенты получают гарантированную скидку
на неакционные товары.
			</li>
			<li class="item3">
				<span>Удобная оплата</span>: наличными курьеру или же банковский перевод.
			</li>
			<li class="item4">
				<span>Квалифицированные менеджеры</span> всегда рады помочь с выбором и консультацией.
			</li>
			<li class="item5">
				<span>100% гарантия возврата.</span> Если товар не подойдет, 
мы вернем деньги.
			</li>
			<li class="item6">
				<span>Отслеживание статуса заказа и доставки.</span>
			</li>			
		</ul><div class="both"></div>
		
	<div class="banner_akciya"><img src="img/banner_akciya.jpg" width="960" height="162" /></div>
	
	<div class="seo_text">
		<?= $text->body ?>
	</div>



        
        