<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\web\View;


$this->title = $brend->name;
$this->registerMetaTag(['name' => 'description', 'content' => $brend->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $brend->name]);

$this->params['breadcrumbs'][] = ['label'=>'Бренды','url'=>['/brends/index']];
$this->params['breadcrumbs'][] = ['label'=>$brend->name];


$this->registerCssFile(Yii::$app->request->BaseUrl.'/js/jsor-jcarousel-7bb2e0a/skins/tango/skin.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jsor-jcarousel-7bb2e0a/lib/jquery.jcarousel.min.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJs("

    jQuery('.jcarousel').jcarousel({
        vertical: true,
        scroll: 2
    });

", View::POS_READY, 'jcarousel');
?>

            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
            ]) 
        
        ?>
                            <div class="both"></div>
            </nav>


<div class="loyout">
  <div class="content">  
    <h1><?=$brend->name?></h1>
    
		<div class="products pn">
		
			<ul>
				
                                <?foreach($products as $item):?>
                                <li class="item">
                                    <?= $this->render('/products/_product',['item'=>$item,'num'=>3]) ?>	
                                </li>
                                <?endforeach;?>
                                
			</ul><div class="both"></div>
		</div>
                            
        <?=LinkPager::widget([
            'pagination' => $pages,
            'registerLinkTags' => true
        ]);?>     
    
    
</div> 
    </div>