<?
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Подписка';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Подписка</h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
		[
		'attribute' => 'id',
		'value'=>'id',
		'contentOptions'=>['style'=>'width: 70px;']
		],
		[
		'attribute' => 'email',
		'value'=>'email',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],
		[
		'attribute' => 'sale',
		'value'=>'sale',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],        
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{delete}',
			        'buttons' => [
                        'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/bg/save','id'=>$model->id], 
                        [
                            'title' => "Редактировать",
                        ]);
                    }
                ],
			'contentOptions'=>['style'=>'width: 70px;']
        ],		
    ],
]) ?>
