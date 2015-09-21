<?
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\News;
use yii\widgets\LinkPager;
use app\components\Text;
?>
<?
$this->title = 'Новости';
$this->registerMetaTag(['name' => 'description', 'content' => 'Новости']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Новости']);
?>

            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            'Новости'
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    
    <div class="content">
	<h1>Новости</h1>
        
        <?foreach($news as $item):?>
	<div class="news_item">
		<a href="<?=Url::to(['news/show','translit'=>$item->translit,'id'=>$item->id])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/news/ico/'.$item->image?>" width="180" height="125" border="0" align="left" /></a>
		<a href="<?=Url::to(['news/show','translit'=>$item->translit,'id'=>$item->id])?>" class="name"><?=$item->title?></a>
		<?=Text::getShort($item->body,200);?>
	</div>        
        <?endforeach;?>
        
        <div class="both"></div>
        <?=LinkPager::widget([
            'pagination' => $pages,
            'registerLinkTags' => true
        ]);?>        
        
    </div>                                    
                                        
</div>