<?
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\News;
?>
<?
$this->title = $news->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $news->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $news->meta_keywords]);
?>

            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            ['label'=>'Новости','url'=>['news/index']],
                            $news->title
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    
    <div class="content">
	<h1><?=$news->title?></h1>
        
            <img src="<?=Yii::$app->request->baseUrl.'/upload/articles/big/'.$news->image?>" width="400" height="400" border="0" align="left" class='pic' />
            <?=$news->body?>
            <p class='date'><?=$news->date?></p>
    </div>                                    
                                        
</div>