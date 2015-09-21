<?
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\News;
use yii\widgets\LinkPager;
use app\components\Text
?>
<?
$this->title = 'Блог';
$this->registerMetaTag(['name' => 'description', 'content' => 'Блог']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Блог']);
?>

            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            'Блог'
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    
    <div class="content">
	<h1>Блог</h1>
        
        <?foreach($news as $item):?>
	<div class="news_item">
		<a href="<?=Url::to(['articles/show','translit'=>$item->translit,'id'=>$item->id])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/articles/ico/'.$item->image?>" width="180" height="125" border="0" align="left" /></a>
		<a href="<?=Url::to(['articles/show','translit'=>$item->translit,'id'=>$item->id])?>" class="name"><?=$item->title?></a><br />
		<?=Text::getShort($item->body,600);?><div class="both"></div>
	</div>        
        <?endforeach;?>
        
        <div class="both"></div>
        <?=LinkPager::widget([
            'pagination' => $pages,
            'registerLinkTags' => true
        ]);?>        
        
    </div>                                    
                                        
</div>