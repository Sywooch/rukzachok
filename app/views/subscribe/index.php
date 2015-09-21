<?
use yii\widgets\Breadcrumbs;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$this->title = 'Подписка';
$this->registerMetaTag(['name' => 'description', 'content' => 'Подписка']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Подписка']);

?>



            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            'Подписаться на акции'
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    
    <div class="content">
	<h1>Подписаться на акции</h1>
<?if($flash = Yii::$app->session->getFlash('success')):?>
    <div class="alert-success"><?=$flash?></div>
<?endif; ?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>       
<?php ActiveForm::end(); ?>        
    </div>                                    
                                        
</div>
