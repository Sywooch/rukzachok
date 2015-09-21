<?
use yii\helpers\Url;
use yii\helpers\Html;
?>
<a href="<?=($info->count>0)?Url::to(['basket/index']):'#'?>">Корзина <span><?=$info->count?></span></a>