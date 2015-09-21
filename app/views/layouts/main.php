<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Menu;
use app\models\Catalog;
use app\models\Products;
use app\models\ViewProduct;
use app\assets\AppAsset;
use yii\web\View;
use app\components\Text;
use app\components\BgWidget;
use app\components\CompareWidget;
use app\models\Subscribe;
use yii\widgets\ActiveForm;

AppAsset::register($this);
$this->registerJs("
	$('.phone .more').bind('click',function(){
		$('.phone .more_block').toggle();
	});
", View::POS_READY, 'phone');
//$this->registerCssFile(Yii::$app->request->BaseUrl.'/css/style.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/basket.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJs("
    $('#basket').basket();
", View::POS_READY, 'basket');

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/call.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJs("
    $('#call').call({token:'".Yii::$app->request->getCsrfToken()."'});
", View::POS_READY, 'call');
$this->registerJs("
    var activeTab = $('.social li:first a').attr('id');
    $('.'+activeTab+'_box').show();
    $('.social li').click(function(){
    $('.hide').hide();
    var activeTab = $(this).find('a').attr('id');
    //alert(activeTab);
    $('.'+activeTab+'_box').show();
    return false;
});
", View::POS_READY, 'social');
$this->registerCssFile(Yii::$app->request->BaseUrl.'/js/jsor-jcarousel-7bb2e0a/skins/tango/skin2.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jsor-jcarousel-7bb2e0a/lib/jquery.jcarousel.min.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJs("

    jQuery('.view_products').jcarousel({
        vertical: true,
        scroll: 2
    });

", View::POS_READY, 'view_products');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= Yii::$app->language ?>" >
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?=Yii::$app->request->baseUrl?>/img/favicon.ico" type="image/x-icon" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= BgWidget::widget() ?>



    <?= $this->render('/basket/_popup') ?>


	<nav class="top"><div class="wrap">
		<div class="fl">
			<ul>
				<li><a href="<?=Url::to(['text/index','translit'=>'oplata_i_dostavka'])?>">Оплата и доставка</a></li>
				<li><a href="<?=Url::to(['text/index','translit'=>'contacts'])?>">Контакты</a></li>
				<li><a href="<?=Url::to(['text/index','translit'=>'help'])?>" id='help'><span>Помощь</span></a></li>
			</ul><div class="both"></div>
		</div>
		<div class="search">
        <form method="get" action="<?=Url::to(['products/search'])?>">
        <input type="text" name="search_str" value='<?=!empty($_GET['search_str'])?Html::encode($_GET['search_str']):''?>' /><input type="submit" value="    " />
        </form>
		</div>
		<div class="fr">
		<?php if(Yii::$app->user->isGuest): ?>	
                    <a href="<?=Url::to(['login/index'])?>" id='login'><span>Личный кабинет</span></a>
		<?php else: ?>
                    <a href="<?=Url::to(['iam/index'])?>"><?=Text::getShort(Yii::$app->user->identity->username,20)?></a>
                    <a href="<?=Url::to(['login/logout'])?>" class='logout'>Выход</a>
                <?php endif; ?>
                </div>
		<div class="both"></div>
	</div></nav>    

    
	<div class="wrap br f">
	
		<div class="header">
			<div class="phone">
				<div class="tel">
                (044) 303 90 15 <!--span class="more"></span-->
				<div class="more_block">
				(044) 303-90-10<br />
                                (044) 428-65-38<br />
				(050) 382-03-00
				</div>
				</div>
				<a href="#" id='call'>Обратный звонок</a>
			</div>
			<div class="basket">
				<div id="basket" class="info">Корзина <span>0</span></div>				
				<span class="more"></span>
                                <div class="both"></div>
                                <div class="compare"><?= CompareWidget::widget() ?></div>
                <div class="basket_hovered">
                    <div class="basket_hovered_white"></div>
                    <div class="basket_items">

                        Загрузка...

                        </div>

                        <div style="float:right;"><a href="<?=Url::to(['basket/index'])?>" class="submit4 bottom3" style="color: #ffffff;">Оформить заказ</a></div>

                </div>
			</div>
			<div class="logo"><a href="<?=Url::to(['site/index'])?>" title="Рюкзачок"><span>Рюкзачок</span></a></div>

			<div class="both"></div>
		</div>
		
		
		
		
		
		
		
		
		<div class="menu">
                        <?php 
                        $active_id = 0;
                        if(!empty($this->params['catalog_id'])){
                        $row = Catalog::findOne($this->params['catalog_id']);
                        $active_id = ($row->parent_id>0) ? $row->parent_id : $row->id;
                        }
                        ?>
			<ul>
                            <?php foreach(Catalog::find()->where(['parent_id'=>0])->orderBy('sort')->all() as $key=>$item):?>
                            <li <?if($item->id==$active_id):?>class="active"<?endif;?>><a href="<?=Url::to(['products/index','translit'=>$item->translit])?>"><?=$item->name?></a></li>
                            <?php endforeach; ?>
			</ul>
			
			<div class="fr">
			<ul>	
				<li class="akciya"><a href="<?=Url::to(['text/index','translit'=>'akcii'])?>">Акции</a></li>
				<li class="brends"><a href="<?=Url::to(['brends/index'])?>">Бренды</a></li>
			</ul>				
			</div>
			<div class="both"></div>	
		</div>
		<?php /**
                <div class="menu_childs">
			<ul>
                            <?php                           
                            $items = Catalog::find();
                            if($row->parent_id>0)$items->where(['parent_id'=>$row->parent_id]);
                            else $items->where(['parent_id'=>$row->id]);
                            foreach($items->orderBy('sort')->all() as $key=>$item):?>
                            <li><a href="<?=Url::to(['products/index','translit'=>$item->translit])?>"><?=$item->name?></a></li>
                            <?php endforeach; ?>
			</ul><div class="both"></div>	
		</div>
                **/?>

<?= $content ?>

	</div>
	
	<div class="bottom">
		<div class="wrap">
			<div class="rightbar2">
                            <p class="txts">
                             <?php
                             $ids = ViewProduct::listView();
                             if(!empty($ids)) {
                                 $products = Products::find()->where(['id' => ViewProduct::listView()])->all();
                                 echo 'Вы просматривали';
                             }else {
                                 $products = Products::find()->where(['new' => '1'])->orderBy('id DESC')->innerJoinWith(['cost'])->groupBy('id')->limit(4)->all();
                                 echo 'Товары со скидкой';
                             }
                             ?>
                                </p>
                            <div class="view_carousel">
                            <ul class='view_products jcarousel-skin-tango2'>
                                <?php
                                 foreach($products as $item):if(!empty($item->cost)):?>
                                <li>
                                        <div class="bg-img-foot-wr"><a class="bg-img-foot" href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/products/ico/'.$item->imageAvator?>" border="0" /></a></div>
					<a href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id])?>" class="name"><?=$item->name?></a>
					<p class="cost"><?=$item->cost->cost?> грн.</p><div class="both"></div>                                    
                                </li>
                                <?php endif; endforeach;?>
                            </ul>
                            </div>
                        </div>
                    
                    
                        <div class="leftbar">
				<ul>
					<li><a href="<?=Url::to(['text/index','translit'=>'contacts'])?>">Контакты</a></li>
					<li><a href="<?=Url::to(['articles/index'])?>">Блог</a></li>
					<li><a href="<?=Url::to(['text/index','translit'=>'oplata_i_dostavka'])?>">Оплата и доставка</a></li>
					<li><a href="<?=Url::to(['iam/index'])?>">Личный кабинет</a></li>
					<li><a href="#">Акции</a></li>
					<li><a href="<?=Url::to(['text/index','translit'=>'about'])?>">О магазине</a></li>
				</ul>
			
			
			<div class="phones">
				(044) 303 90 15
			</div>

			</div>
                    
                    <div class="content2">
                        <p class="txts">Подписаться на акции</p>
                        <?php 
                        $subscribe = new Subscribe;
                        $form = ActiveForm::begin(['action' => '/subscribe']); 
                        ?>
                        <?php echo $form->field($subscribe,'email')->textInput(array('placeholder' => 'E-mail'))->label(false); ?>
                        <?=$form->field($subscribe, 'sale')->dropDownList(['10' => '10%', '20' => '20%'],['prompt'=>'Скидка'])->label(false); ?>
                        <div class="saletxt">укажите желаемый размер скидки</div>
                        <?php echo Html::submitButton(' Подписаться ',array('class'=>'submit4m')); ?>
                         <?php ActiveForm::end(); ?>
                        <div class="both"></div><br><br><br>
                            
                        
					<ul class="social">						
						<li><a class="vk" id = "vk" target="_blank">vk.com</a></li>
                                                <li><a class="fb" id = "fb" >facebook.com</a></li>
						<li><a class="ok" id = "ok"  target="_blank">odnoklassniki.ru</a></li>
						<li><a class="gp" id = "gp" href="https://plus.google.com/+ArtwebUaAgency" target="_blank">plus.google.com</a></li>
					</ul> <div class="both"></div>                       
                        
                        <div class="socialbox">
                            <div class="vk_box hide">
                        <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>

                        <!-- VK Widget -->
                        <div id="vk_groups"></div>
                        <script type="text/javascript">
                        VK.Widgets.Group("vk_groups", {mode: 0, width: "390", height: "213", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 99037905);
                        </script>
                        </div>
                            <div class="fb_box hide">
                            <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.4";
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-page" data-href="https://www.facebook.com/pages/Rukzachokcomua/1031766016856430" data-width="390" data-height="213" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/pages/Rukzachokcomua/1031766016856430"><a href="https://www.facebook.com/pages/Rukzachokcomua/1031766016856430">Rukzachok.com.ua</a></blockquote></div></div>
                            </div> 
                            
                                <div class="gp_box hide">
                            
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'ru'}
</script>

<div class="g-page" data-href="https://plus.google.com/106638911242676218673" data-rel="publisher"></div>                                    
                            </div>
                            
                                <div class="ok_box hide">
 <div id="ok_group_widget"></div>
<script>
!function (d, id, did, st) {
  var js = d.createElement("script");
  js.src = "http://connect.ok.ru/connect.js";
  js.onload = js.onreadystatechange = function () {
  if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
    if (!this.executed) {
      this.executed = true;
      setTimeout(function () {
        OK.CONNECT.insertGroupWidget(id,did,st);
      }, 0);
    }
  }}
  d.documentElement.appendChild(js);
}(document,"ok_group_widget","52719911305396","{width:390,height:213}");
</script>
                        
                                    
                            </div>
                            <div class="tw_box hide">Пока нет!</div>

</div>
                            
                    
                    
                    
                    
                    </div>
                    
                    <div class="both"></div>
		
		</div>
	
	</div>
        
        
        
	<div class="fotter">
                <div class="wrap">
                    <div class="fl">© 2015 Rukzachok. Все права защищены.</div>
                    <div class="fr"><a href="http://artweb.ua" target="_blank">Создание сайтов</a> <img src="<?=Yii::$app->request->baseUrl?>/img/artweb.png" width="58" height="17" alt="ArtWeb Studio" /></div>
                    <div class="both"></div>
                </div>
        </div>    

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>