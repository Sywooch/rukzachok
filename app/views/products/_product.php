<?php
use yii\helpers\Url;
?>
					<div class="boxitem">
                                        <div class="pixbox"><a href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/products/ico/'.$item->imageAvator?>" border="0" /></a></div>
					<a href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id])?>" class="name"><?=$item->name?></a>
					<p class="cost"><?=$item->cost->cost?> грн.</p>
					</div>
                                        <a href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id])?>" class="link_buy">Купить</a>
  <div class="mycarousel">
  <ul class="jcarousel jcarousel-skin-tango">
    <?php foreach($item->mods as $mods):?>  
    <li><a href="<?=Url::to(['products/show','translit_rubric'=>$item->catalog->translit,'translit'=>$item->translit,'id'=>$item->id,'#'=>'m'.$mods->id])?>"><img src="<?=Yii::$app->request->baseUrl.'/upload/mod/ico/'.$mods->imageAvator?>" width="40" height="40" alt="<?=$mods->name?>" /></a></li>
    <?php endforeach;?>
  </ul>
 </div>  
