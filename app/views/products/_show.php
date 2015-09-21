<?
use yii\widgets\Breadcrumbs;
use yii\web\View;


$this->title = (!empty($product->meta_title))?$product->meta_title:$product->name;
$this->registerMetaTag(['name' => 'description', 'content' => ((!empty($product->meta_description))?$product->meta_description:$product->name)]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $product->meta_keywords]);
$this->registerJs("
    var checkData = function(obj){
        $('#cost').text($(obj).data('cost'));
        $('#product_id').val($(obj).data('id'));    
    }
    $('.fasovka input[type=\"radio\"]').click(function() {
        checkData(this);
    });
    checkData($( '.fasovka input:checked' ));
", View::POS_READY, 'fasovka');

$this->registerJs("

    $('#product_gallery a').click(function() {
       var image = $(this).attr('href');
       $('#productPic').attr('src', image);
        return false;
    });

", View::POS_READY, 'gallery');

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.sliderkit.1.9.2.pack.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\YiiAsset']]);
$this->registerJs("

                $('.skit').sliderkit({
			cssprefix: 'skit',
			shownavitems: 3,
			auto: false,
			scroll: 1,
			circular: false,
			// freeheight: true,
			scrollspeed: 500
		});

", View::POS_READY, 'sliderkit');
?>
            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            ['label'=>'Каталог','url'=>['catalog/all']],
                            ['label'=>$catalog->parent->name,'url'=>['catalog/index','translit'=>$catalog->parent->translit]],
                            ['label'=>$catalog->name,'url'=>['products/index','translit'=>$catalog->translit]],
                            $product->name,    
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    

                        <div class="leftbar">
				<?= $this->render('/catalog/_catalog_box',['catalog'=>$catalog]) ?>
	
			</div>
			<div class="content">
					<h1><?=$product->name?></h1>
					<div class="ten2"></div>
                                        
					<div class="leftbar_product">
					<div class="product_pic_big">
						<img id="productPic" src="<?=Yii::$app->request->baseUrl.'/upload/products/big/'.$product->image?>" width="400" height="400" border="0" />
                                                <div id="pic_notvisible">
                                                <img src="<?=Yii::$app->request->baseUrl.'/upload/products/big/'.$product->image?>" width="400" height="400" border="0" />
                                                </div>
                                        </div>
                                        <div class='skit'>
                                            <div class="skit-nav">
						<div id="product_gallery" class="skit-nav-clip">
						<ul>
                                            <?foreach($product->fotos as $key=>$item):?>
                                            <li>
                                            <a href="<?=Yii::$app->request->baseUrl.'/upload/fotos/big/'.$item->image?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/fotos/ico/'.$item->image?>" width="100" height="100" border="0" alt="<?=$item->name?>" /></a>
                                            </li>
                                            <?endforeach;?>
                                            </div>
                                                
                                            <a href="#" class="skit-btn skit-nav-btn skit-nav-prev"></a>
                                            <a href="#" class="skit-btn skit-nav-btn skit-nav-next"></a>
                                        </div>
                                            </div>    
					
					</div>
					<div class="content_product">
						<p class="txtf">Фасовка</p>
						<div class="fasovka">
							<?foreach($product->mods as $key=>$item):?>
                                                        <input type="radio" name="fasovka" data-cost="<?=$item->cost?>" data-id="<?=$item->id?>" id="f<?=$key?>" <?=($key==0)?'checked':'';?>> <label for="f<?=$key?>"><?=$item->name?></label>
							<?endforeach;?>
						</div>
						<div class="count">
							<label for="count" class="txtf">Количество</label> <input id="count" min="1" value="1" type="number" />
						</div>
						<div class="boy_box">
							<input type='hidden' id='product_id' />
                                                        <a href="#" rel='product' class="buy fr">Купить</a>
							<div class="fl txtfb">цена <span id="cost">0</span> грн</div><div class="both"></div>
						</div>
						<div class="info">
							<p class="txtf">Характеристики</p>
							<?=$product->char?>
							
							<p class="txtf">Описание</p>
                                                        <?=$product->body?>
                                                </div>
						
					</div>
					<div class="both"></div>	


                        </div><div class="both"></div>


</div>