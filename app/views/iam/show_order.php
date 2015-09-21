<?
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;


$this->title = 'Заказ №'.$model->id;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Заказ №<?=$model->id?></h1>

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
		'attribute' => 'art',
		'value'=>'art',
		'contentOptions'=>['style'=>'width: 50px;']
		],        
		[
		'attribute' => 'product_name',
		'value'=>'product_name',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],
		[
		'attribute' => 'name',
		'value'=>'name',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],
		[
		'attribute' => 'cost',
		'value'=>'cost',
		'contentOptions'=>['style'=>'width: 100px;']
		],       
		[
		'attribute' => 'count',
		'value'=>'count',
		'contentOptions'=>['style'=>'width: 30px;']
		], 
		[
		'attribute' => 'sum_cost',
		'value'=>'sum_cost',
		'contentOptions'=>['style'=>'width: 100px;']
		],
        
		
    ],
]) ?>

