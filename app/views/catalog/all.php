<?
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = 'Каталог';
$this->registerMetaTag(['name' => 'description', 'content' => 'Каталог']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Каталог']);

?>
            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => ['Каталог'],
            ]) ?>
                            <div class="both"></div>
            </nav>
<div class="loyout">
<div class="content">
	<h2>Каталог</h2>
	<?/**foreach($catalogs as $item):?>
	<div class="rubric_item">
		<a href="<?=Url::to(['catalog/index','translit'=>$item->translit])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/catalog/ico/'.$item->image?>" width="195" height="186" border="0" /></a>
                <a href="<?=Url::to(['catalog/index','translit'=>$item->translit])?>" class="name"><?=$item->name;?></a>
	</div>
        <? endforeach;**/?> 
        
        
		<div class="rubrics">
			<ul>
				<li class="item1"><a href="<?=Url::to(['products/index','translit'=>'ryukzaki'])?>">Рюкзаки</a></li>
				<li class="item2"><a href="<?=Url::to(['products/index','translit'=>'sumki'])?>">сумки</a></li>
				<li class="item3"><a href="<?=Url::to(['products/index','translit'=>'chehly'])?>">чехлы</a></li>
				<li class="item4"><a href="<?=Url::to(['products/index','translit'=>'nesessery'])?>">Несессеры</a></li>
				<li class="item5"><a href="<?=Url::to(['products/index','translit'=>'koshelki'])?>">кошельки</a></li>
			</ul><div class="both"></div>
		</div>        
</div>
</div>    
