<?
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\Catalog;
?>
<?
$this->title = $catalog->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $catalog->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $catalog->meta_keywords]);
?>
            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
               
                'links' => [ ['label'=>'Каталог','url'=>['catalog/all']],
                                $catalog->name],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    

                        <div class="leftbar">
				<?= $this->render('_catalog_box',['catalog'=>$catalog]) ?>
	
			</div>
			<div class="content">
					<h1><?=$catalog->name?></h1>
					<div class="ten2"></div>
                                        
                                        <?foreach($catalog->childs as $item):?>
                                        	<div class="rubric_item2">
                                                        <a href="<?=Url::to(['products/index','translit'=>$item->translit])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/catalog/ico/'.$item->image?>" width="195" height="186" border="0" /></a>
                                                        <a href="<?=Url::to(['products/index','translit'=>$item->translit])?>" class="name"><?=$item->name?></a>
                                                </div>

                                        <?endforeach;?><div class="both"></div>
                                        
                                        <?=$catalog->body?>

                        </div><div class="both"></div>


</div>                    