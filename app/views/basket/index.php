<?
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use app\models\Delivery;

$this->title = 'Корзина';
$this->registerMetaTag(['name' => 'description', 'content' => 'Корзина']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Корзина']);

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.mask.js',['position'=>View::POS_HEAD,'depends'=>['yii\web\YiiAsset']]);

$this->registerJs("
$('#order-phone,#order-phone2').mask('(000) 000-0000');
", View::POS_READY, 'mask');


$this->registerJs("
$('#order-delivery input[type=\"radio\"]').click(function(){
    $('.delivery-data').hide();
    $('#delivery-data-'+$(this).val()).show();
});
", View::POS_READY, 'order-delivery');
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
<div class="ten"></div>
<?= Html::a('Вернуться в каталог', ['/site/index'], ['class'=>'btn-success']) ?>
<?php $form = ActiveForm::begin(['enableClientScript' => false]); ?>
<div class="rightbar">
 <div class="form-order">   
<?php echo $form->field($modelOrder,'surname'); ?>
<?php echo $form->field($modelOrder,'name'); ?>
<?php echo $form->field($modelOrder,'patronymic'); ?>    
<?php echo $form->field($modelOrder,'phone'); ?> 
<?php echo $form->field($modelOrder,'phone2'); ?> 
<?php echo $form->field($modelOrder,'city'); ?>    
<?php echo $form->field($modelOrder,'adress'); ?>
<?php echo $form->field($modelOrder,'email'); ?>
    <?= $form->field($modelOrder, 'delivery')
        ->radioList(ArrayHelper::map(Delivery::find()->where(['parent_id'=>0])->asArray()->all(), 'id', 'title'))
    ?>
<div class="both"></div> 

<?foreach(Delivery::find()->where(['parent_id'=>0])->all() as $item):?>
<div class='delivery-data' id='delivery-data-<?=$item->id?>'>
        <?=$item->text?>
    <?= $form->field($modelOrder, 'delivery')
        ->radioList(ArrayHelper::map(Delivery::find()->where(['parent_id'=>$item->id])->asArray()->all(), 'id', 'title'),['id' => 'order-delivery-childs'])->label(false)
    ?>    
</div>    
<?endforeach;?>

<?php echo $form->field($modelOrder, 'payment')->radioList(['Оплатить наличными'=>'Оплатить наличными','Оплатить на карту Приват Банка'=>'Оплатить на карту Приват Банка','Оплатить по безналичному расчету'=>'Оплатить по безналичному расчету','Оплатить Правекс-телеграф'=>'Оплатить Правекс-телеграф','Наложенным платежом'=>'Наложенным платежом']); ?>    
<div class="both"></div>


<?php echo $form->field($modelOrder,'body')->textarea(['rows'=>7]); ?>     
<?php echo Html::submitButton(' Оформить заказ ',array('class'=>'submit4')); ?>
 </div>   
</div>
			<div class="content">
                            
                            
<?foreach($basket_mods as $i=>$item):?>
			<div class="basket_item">
				<a href="<?=Url::to(['products/show','translit_rubric'=>$item->translit_rubric,'translit'=>$item->translit,'id'=>$item->product_id])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/products/ico/'.$item->image?>" border="0" width="90" height="120" align="left" /></a>
				<div class="info">
				<a href="<?=Url::to(['products/show','translit_rubric'=>$item->translit_rubric,'translit'=>$item->translit,'id'=>$item->product_id])?>" class="link2"><?=$item->product_name?></a>
				<p>Код: <?=$item->art?>, цвет: <?=$item->color?></p>
                                <?php echo $form->field($item,'['.$i.']id')->hiddenInput()->label(false); ?>
                                <?php echo $form->field($item,'['.$i.']product_name')->hiddenInput()->label(false); ?>
                                 <?php echo $form->field($item,'['.$i.']art')->hiddenInput()->label(false); ?>
                                <?php echo $form->field($item,'['.$i.']name')->hiddenInput()->label(false); ?>
                                <?php echo $form->field($item,'['.$i.']cost')->hiddenInput()->label(false); ?>
                                <?php echo $form->field($item,'['.$i.']sum_cost')->hiddenInput()->label(false); ?>
                                <div class="count">
                                        <div class="fr txtf"><span style="color:silver">цена за один <?=$item->cost?> грн,</span> цена <?=$item->sum_cost?> грн</div>
                                        <label for="count" class="txtf">Количество</label> <?php echo $form->field($item,'['.$i.']count')->textInput(['type'=>'number'])->label(false); ?><div class="both"></div>
				</div>
				<a href="<?=Url::to(['basket/index','deleteID'=>$item->id]);?>" class="del">Удалить</a>
				</div><div class="both"></div>
			</div>
<?endforeach;?>
				
<?php echo Html::submitButton(' Пересчитать ',array('name'=>"update",'class'=>'submit4 fl')); ?>

			<div class="total">
			<?= $form->field($modelOrder, 'total')->hiddenInput(['value'=>$modelMod->getSumCost()])->label(false); ?> 	
                            Общая сумма: <?=$modelMod->getSumCost();?> грн.
			</div>
<div class="both"></div>			



			</div><div class="both"></div>
 <?php ActiveForm::end(); ?>			
			
			
</div>