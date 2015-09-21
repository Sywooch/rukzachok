<?
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\Catalog;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\LinkPager;
use app\models\Fasovka;
use app\models\Type;
use app\models\Brends;
?>
<?
$this->title = 'Поиск';
$this->registerMetaTag(['name' => 'description', 'content' => 'Поиск']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Поиск']);



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
                'links' => [
                            ['label'=>'Каталог','url'=>['catalog/all']],
                            'Поиск'
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    
    <div class="content">
        <h1>Поиск</h1>
        
	<div class="ten"></div>
        <?=empty($products)?'Не чего не найдено!':''?>
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
        ]);?>
        <div>&nbsp;</div>
	<div class="ten"></div>        
        
        
    </div>
    
</div>    
                                        