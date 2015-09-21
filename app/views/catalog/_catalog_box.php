<?
use yii\helpers\Url;
use app\models\Catalog;
?>
                                <div class="filtes_box"><div class="w">
					<ul>
                                            <?foreach(Catalog::getCatalogs() as $item):?>
                                            <li>
                                                <a href="<?=Url::to(['catalog/index','translit'=>$item->translit])?>" <?if($catalog->id = $item->id):?>class="active"<?endif;?>><?=$item->name?></a>
                                            <?if($catalog->id = $item->id && !empty($item->childs)):?>
                                            <ul>
                                                <?foreach($item->childs as $item_child):?>
                                                    <li><a href="<?=Url::to(['products/index','translit'=>$item_child->translit])?>"><?=$item_child->name?></a></li>
                                                <?endforeach;?>
                                            </ul>
                                            <?endif;?>
                                            </li>
                                            <?endforeach;?>    
					</ul>			
				</div></div>