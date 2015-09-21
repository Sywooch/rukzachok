<?
use yii\widgets\Breadcrumbs;
use yii\web\View;
use yii\helpers\Url;



$this->title = (!empty($product->meta_title))?$product->meta_title:$product->name;
$this->registerMetaTag(['name' => 'description', 'content' => ((!empty($product->meta_description))?$product->meta_description:$product->name)]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $product->meta_keywords]);
$this->registerJs("
    var checkData = function(obj){
        $('#cost').text($(obj).data('cost'));
        $('#old_cost').text($(obj).data('old_cost'));
        if($(obj).data('old_cost')==0)$('strike').hide();
        $('#product_id').val($(obj).data('id'));
        $('#art').text($(obj).data('art'));
        $('#color').text($(obj).data('color'));
        $('#pic').attr('src',$(obj).data('image'));
        $('#picoriginal').attr('href',$(obj).data('imageoriginal'));

    }

    $('.product_mod li a').click(function() {
        checkData(this);

		Shadowbox.setup($('#picoriginal'));
        return false;
    });
		
    
    var obj = '.product_mod li:first a';
    if (window.location.hash){
	var obj = window.location.hash;
		 
    }
    //alert(obj);
    checkData($( obj ));
", View::POS_READY, 'fasovka');

$this->registerJs("

	$('#nav_product li a').addClass('active');
	$('#nav_product li').find('.info').toggle();
       
	$('#nav_product li a').bind('click',function(){
		if($(this).parent().find('.info').css('display')=='none')$(this).addClass('active');
		else $(this).removeClass('active');
		$(this).parent().find('.info').toggle();
		
		return false;
	});

", View::POS_READY, 'nav_product');


$this->registerCssFile(Yii::$app->request->BaseUrl.'/js/shadowbox-3.0.3/shadowbox.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/shadowbox-3.0.3/shadowbox.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJs("
Shadowbox.init({

});
", View::POS_READY, 'Shadowbox');
?>



            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            ['label'=>'Каталог','url'=>['catalog/all']],
                           // ['label'=>$catalog->parent->name,'url'=>['catalog/index','translit'=>$catalog->parent->translit]],
                            ['label'=>$catalog->name,'url'=>['products/index','translit'=>$catalog->translit]],
                            $product->name,    
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>
<?if($flash = Yii::$app->session->getFlash('success')):?>
    <div class="alert-success"><?=$flash?></div>
<?endif; ?>
		<div class="loyout">
                    
			
			<div class="productLeftBar">
			<h1><?=$product->name?></h1>
			<div class="begin">Цветовые решения</div>
			<ul class="product_mod">
				<?foreach($product->mods as $key=>$item):?>
                                <li><a id='m<?=$item->id?>' href="#" data-cost="<?=$item->cost?>" data-old_cost="<?=$item->old_cost?>" data-id="<?=$item->id?>" data-art="<?=$item->art?>" data-color="<?=$item->color?>" data-image="<?=Yii::$app->request->baseUrl.'/upload/mod/big/'.$item->imageAvator?>" data-imageoriginal="<?=Yii::$app->request->baseUrl.'/upload/mod/'.$item->imageAvator?>" title="<?=$item->color?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/mod/ico/'.$item->imageAvator?>" alt="<?=$item->name?>" border="0" width="40" height="40" /></a></li>
				<?endforeach;?>
			</ul><div class="both"></div>
			
			<div class="cost_box">
                            <div class='params'>код: <span id='art'></span><br /> цвет: <span id='color'></span></div> 
                                <div class="w">
					<strike><span id='old_cost'>0</span> грн.</strike><br />
					<span class="cost"><span id='cost'>0</span> <span class="valute">грн.</span></span>
				</div>
				<input type='hidden' id='product_id' />
                                <a href="#" rel='product' class="link_buy fl">В Корзину</a><div class="both"></div>
			</div>
			
			<div class="product_service">
				<ul>
					<li class="item1"><a href="<?=Url::to(['iam/share','id'=>$product->id])?>">Добавить в закладки</a></li>
					<li class="item2"><a href="<?=Url::to(['iam/price','id'=>$product->id])?>">Узнать о снижение цены</a></li>
					<li class="item3"><a href="<?=Url::to(['products/compare','id'=>$product->id])?>">Добавить в сравнение</a></li>
				</ul>
			</div>
			
			</div>	
			
			<div class="productRightBar">
				<ul id="nav_product">
					<li><a href="#">Характеристики</a>
						<div class="info">
                                                    <p>Бренд: <?=$product->brend->name?></p>
						<?foreach($product->params as $key=>$item):?>
                                                    <p><?=$item->name?> <?=$item->size?></p>
                                                <?endforeach;?>
						</div>
					</li>
					<li><a href="#">Описание</a>
						<div class="info">
						<?=$product->body_ru?>
						</div>
					</li>
					
				</ul>
			</div>
		
<div class="content">


	<div class="pic">
	<center>
		<a href="#" rel="shadowbox[gal]" id="picoriginal"><img id="pic" src="<?=Yii::$app->request->baseUrl.'/upload/products/big/'.$product->imageAvator?>" border='0' /></a>
	</center>
        </div>
			<ul class="product_colors">
			<?foreach($product->fotos as $key=>$item):?>	
                            <li><a href="<?=Yii::$app->request->baseUrl.'/upload/fotos/big/'.$item->imageAvator?>" rel="shadowbox[gal]"><img src="<?=Yii::$app->request->baseUrl.'/upload/fotos/ico/'.$item->imageAvator?>" border="0" width="100" height="100" alt="<?=$item->name?>" /></a></li>
			<?endforeach;?>
                        </ul>		


</div><div class="both"></div>
		</div>