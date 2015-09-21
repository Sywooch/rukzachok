<?
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

$this->title = 'Корзина';
$this->registerMetaTag(['name' => 'description', 'content' => 'Корзина']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Корзина']);

?>
            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            'Корзина'
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>



<div class="layout">
    
    <h1>Корзина</h1>
Ваш заказ принят! Большое Спасибо! Менеджер с Вами свяжется в ближайшее время.

</div>
