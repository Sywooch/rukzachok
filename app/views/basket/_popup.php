<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="black hidden">
    <div class="item_added_win">
        <a href="#" class="black_close"></a>
        <div class="block_content">
            <h2>Товар добавлен в корзину</h2>
            <div class="items">
                <div class="basket_items">

                        Загрузка...

                    </div>
                <div style="display:table;margin-top:25px;">
                    <div class="cont_shop_but"><a href="#" class="cont_shop">Продолжить покупки</a></div>
                    <div style="display:table-cell;padding-left:240px;">

                        <a href="<?=Url::to(['basket/index'])?>" class="submit4 bottom3" style="color:white;">Оформить заказ</a>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>