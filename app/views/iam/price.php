<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

$this->title = 'Пожелания';
$this->registerMetaTag(['name' => 'description', 'content' => 'Пожелания']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Пожелания']);

?>

<h1>Пожелания</h1>

<hr />
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
		[
		'attribute' => 'id',
		'value'=>'id',
		'contentOptions'=>['style'=>'width: 70px;']
		],
		[
		'attribute' => 'date_time',
		'value'=>'date_time',
		'contentOptions'=>['style'=>'width: 150px;']
		],        
		[
		'attribute' => 'product_name',
		'value'=>function($data){
                            return (!empty($data->product->name))?Html::a($data->product->name, ['products/show','translit_rubric'=>$data->product->catalog->translit,'translit'=>$data->product->translit,'id'=>$data->product->id]):'Этот товар удален с сайта';
                        },
                'format'=>'raw',
		],

        
		
    ],
]) ?>