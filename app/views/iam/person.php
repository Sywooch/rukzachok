<?
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;



$this->title = 'Профиль';
?>

            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => ['Мой кабинет'],
            ]) ?>
                            <div class="both"></div>
            </nav>
<div class="lay_title">
    <h1 class="uppercase center">Личные данные</h1>
</div>
<div class="layout">
    <div class="leftbar">
        <div class="mycabinet">
            <div class="begin">Мой кабинет</div>
            <ul>
                <li><a href="<?=Url::to(['iam/index'])?>" class="active">Личные данные</a></li>
                <li><a href="<?=Url::to(['iam/myorders'])?>">Мои заказы</a></li>
                <li><a href="<?=Url::to(['iam/share'])?>">Закладки</a></li>
                <!--li><a href="<?=Url::to(['iam/price'])?>">Пожелания</a></li-->
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="user_edit_area">
            <div class="user_data">
                <div class="col"><div class="title">Имя</div><div class="data"><?=Html::encode($model->name) . ' ' . Html::encode($model->surname);?></div></div>
                <div class="col"><div class="title">Электронная почта</div><div class="data"><?=Html::encode($model->username)?></div></div>
                <div class="col last"><div class="title">Телефон</div><div class="data"><?=Html::encode($model->phone)?></div></div>
                <div class="both"></div>
            </div>
            <div class="edit_menu">
                <div><?=Html::a('Редактировать личные данные', ['/iam/edit'], ['class'=>'dotted'])?></div>
                <!--div><a href="#" class="dotted">Изменить пароль</a></div-->
                <div><a href="<?=Url::to(['login/logout'])?>">Выход</a></div>
                <div class="both"></div>
            </div>
        </div>
    </div>
    <div class="both"></div>
</div>

