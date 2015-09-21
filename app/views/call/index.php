<?
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\News;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

?>
<?
$this->title = 'Обратный звонок';
$this->registerMetaTag(['name' => 'description', 'content' => 'Обратный звонок']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Обратный звонок']);
?>

            <nav class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'links' => [
                            'Обратный звонок'
                            ],
            ]) ?>
                            <div class="both"></div>
            </nav>

<div class="layout">
    
    <div class="content">
	<h1>Обратный звонок</h1>
        
<?php $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>       
<?php ActiveForm::end(); ?>        
    </div>                                    
                                        
</div>