<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>
<?
$this->title = 'Импорт';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Импорт</h1>
Файл успешно загружен на сайт!
<br /><br />
Если вы загружали файл товаров, то запустите из консоли эти комманды: <br />
cd www/rukzachok.com.ua/app<br />
php yii hello/import<br />
<br />
Если вы загрузили обновление цен, то запустите из консоли эти комманды: <br />
cd www/rukzachok.com.ua/<br />
php updatemods/cr.php<br />