<?
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\News;
use yii\widgets\LinkPager;
use app\components\Text
?>
<?
$this->title = 'Обратный звонок';
$this->registerMetaTag(['name' => 'description', 'content' => 'Обратный звонок']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Обратный звонок']);
?>

            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            'Обратный звонок'
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    
    <div class="content">
	<h1>Обратный звонок</h1>
        
       Мы получили от Вас сообщение! Мы свяжемся с Вами в ближайшее время.
        
    </div>                                    
                                        
</div>