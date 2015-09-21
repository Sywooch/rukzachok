<?
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['enableClientScript' => false,'id'=>'basket_form2']); ?>
<?foreach($basket_mods as $i=>$item):?>
<div class="basket_item">
    <?php echo $form->field($item,'['.$i.']id')->hiddenInput()->label(false); ?>
    <div style="display: table-cell;vertical-align: middle;"><a href="#" data-id="<?=$item->id?>" class="delete_button" style="margin-right:20px;"></a></div>
    <div style="width:100px;height:100px;display: table-cell;vertical-align: middle; border:1px solid #d2d2d2;text-align:center;margin-left:10px;margin-right:10px;"><img src="<?=Yii::$app->request->baseUrl.'/upload/products/ico/'.$item->image?>" style="margin:0;" width="100"></div>
    <div style="display: table-cell;vertical-align: middle; font-size:15px;width:210px; font-weight:normal;padding-left:15px;">
        <div><?=$item->product_name?></div>
        <div style="text-transform:none; margin-top:20px; font-weight:bold;">
            <?if($item->old_cost>0):?><div style="text-decoration:line-through;font-size:13px;"><?=$item->old_cost?> грн.</div><?endif;?>
            <div style="font-size:15px;color:#f75d50;"><?=$item->cost?> грн.</div>
        </div>
    </div>
    <div style="display: table-cell;vertical-align: middle;">
        <a href="#" style="color:#95ba2f" class="minus"></a><?php echo $form->field($item,'['.$i.']count',['template'=>'{input}'])->textInput(['type'=>'number','class' => 'item_num','disabled1'=>true])->label(false); ?><a href="#" style="color:#95ba2f" class="plus"></a>
    </div>
    <div style="display: table-cell;vertical-align: middle; font-size:16px;color:#f75d50; font-weight:bold; padding-left:54px;"><?=$item->sum_cost?> грн.</div>
    <div  style="clear:both;"></div>
</div>
<?endforeach;?>

    <div class="basket_sum">
        <div class="sum_text" style="float:left;">Всего: <span><?=$modelMod->getSumCost()?> грн.</span></div>
    </div>
<?php ActiveForm::end(); ?>