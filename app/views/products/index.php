<?
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\models\Catalog;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\LinkPager;
use app\models\Filters;
use app\models\Type;
use app\models\Brends;
use app\components\FiltersWidget;
use app\components\BrendsWidget;
?>
<?
$this->params['catalog_id'] = $catalog->id;
$this->title = $catalog->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $catalog->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $catalog->meta_keywords]);

$this->registerCssFile(Yii::$app->request->BaseUrl.'/css/begunok.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.ui-slider.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/begunok.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);

$this->registerCssFile(Yii::$app->request->BaseUrl.'/js/jsor-jcarousel-7bb2e0a/skins/tango/skin.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jsor-jcarousel-7bb2e0a/lib/jquery.jcarousel.min.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\JqueryAsset']]);
$this->registerJs("

    jQuery('.jcarousel').jcarousel({
        vertical: true,
        scroll: 2
    });

", View::POS_READY, 'jcarousel');

$this->params['breadcrumbs'][] = ['label'=>'Каталог','url'=>['/catalog/all']];
if(!empty($catalog->parent))$this->params['breadcrumbs'][] = ['label'=>$catalog->parent->name,'url'=>['products/index','translit'=>$catalog->parent->translit]];
$this->params['breadcrumbs'][] = ['label'=>$catalog->name];
?>
            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
            ]) 
        
        ?>
                

                            <div class="both"></div>
            </nav>



		<div class="loyout">
			<div class="leftbar">
				<img src="<?=Yii::$app->request->baseUrl?>/img/new_coll.png" width="112" height="22" /><br />
				<img src="<?=Yii::$app->request->baseUrl?>/img/pro.png" width="42" height="22" />
				
                                <?= BrendsWidget::widget(['translit' => $catalog->translit,'catalog_id' => $catalog->id]) ?>

                                <?= FiltersWidget::widget(['translit' => $catalog->translit,'catalog_id' => $catalog->id]) ?>

				<div class="cost_box filters">
				<div class="begin">Цена</div>
		<?php $form = ActiveForm::begin(['enableClientScript' => false]); ?>
			<input type="hidden" value="500" id="max" />
			<div class="sliderCont">
					<div id="begunok"></div>
			</div>
			<div class="formCost">
				<?php echo $form->field($modelProducts,'minCost'); ?>
				<?php echo $form->field($modelProducts,'maxCost'); ?>
			</div>
		 <?php echo Html::submitButton(' Искать ',array('class'=>'submit4','style'=>'margin-left:50px;')); ?>
                            <?php ActiveForm::end(); ?>	<div class="both"></div>
				</div>
					
			</div>
			<div class="content">


		<h1><?=$catalog->name?></h1>
		<div class="products pn">
		
			<ul>
				
                                <?foreach($products as $item):?>
                                <li class="item">
                                    <?= $this->render('_product',['item'=>$item,'num'=>3]) ?>	
                                </li>
                                <?endforeach;?>
                                
			</ul><div class="both"></div>
		</div>
                            
        <?=LinkPager::widget([
            'pagination' => $pages,
            'registerLinkTags' => true
        ]);?> <div class="both"></div>                           

</div><div class="both"></div>
		
                
 </div>





