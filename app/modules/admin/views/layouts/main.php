<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

?>
<?php $this->beginContent('@app/modules/admin/views/layouts/layout.php'); ?>

    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::t('admin', 'AdminPanel'),
                'brandUrl' => ['/admin/menu/index'],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                        ['label' => 'Экспорт', 'url' => ['/admin/export/index']],
                        ['label' => 'Импорт', 'url' => ['/admin/import/index']],
                        ['label' => 'Заказы', 'url' => ['/admin/orders/index']],
                        ['label' => 'Пользователи', 'url' => ['/admin/users/index']],
                        ['label' => 'Группы пользователей', 'url' => ['/admin/group/index']],
                    /*['label' => 'Язык',
						'items'=>[['label' => 'Contact', 'url' => ['/site/contact']]]
					],*/
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/admin/login/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
<div class="leftbar">
<div class="well">			
<?php 
echo Nav::widget([
	'encodeLabels' => false,
    'items'=>[
		['label'=>'<span class="glyphicon glyphicon-th-list"></span> Меню', 'url'=>['/admin/menu/index']],
		['label'=>'<span class="glyphicon glyphicon-file"></span> Текстовые страницы', 'url'=>['/admin/text/index']],
		['label'=>'<span class="glyphicon glyphicon-th"></span> Каталог', 'url'=>['/admin/catalog/index']],
                ['label'=>'<span class="glyphicon glyphicon-th"></span> Бренды', 'url'=>['/admin/brends/index']],
		['label'=>'<span class="glyphicon glyphicon-list-alt"></span> Новости', 'url'=>['/admin/news/index']],
		['label'=>'<span class="glyphicon glyphicon-list-alt"></span> Статьи', 'url'=>['/admin/articles/index']],
		['label'=>'<span class="glyphicon glyphicon-repeat"></span> Слайдер - баннера', 'url'=>['/admin/slider/index']],
                ['label'=>'<span class="glyphicon glyphicon-repeat"></span> Фон', 'url'=>['/admin/bg/index']],
                ['label'=>'<span class="glyphicon glyphicon-repeat"></span> Подписка', 'url'=>['/admin/subscribe/index']],
        
        ],
]); ?>			
</div>
</div>
<div class="content">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>			
            <?= $content ?>
</div>			
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?=Yii::t('admin', 'AdminPanel');?> <?= date('Y') ?></p>
            <p class="pull-right">ArtWeb Studio</p>
        </div>
    </footer>


<?php $this->endContent(); ?>