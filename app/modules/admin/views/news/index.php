<?
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Новости</h1>
<?= Html::a('Создать', ['/admin/news/save'], ['class'=>'btn btn-success']) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
		[
		'attribute' => 'id',
		'value'=>'id',
		'contentOptions'=>['style'=>'width: 70px;']
		],
		[
		'attribute' => 'image',
                'format' => 'image',    
		'value'=>function($data) { return Yii::$app->request->BaseUrl.'/upload/news/ico/'.$data->image; },
		'contentOptions'=>['style'=>'width: 100px;']
		],        
		[
		'attribute' => 'title',
		'value'=>'title',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],		
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}',
			        'buttons' => [
                        'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/news/save','id'=>$model->id], 
                        [
                            'title' => "Редактировать",
                        ]);
                    }
                ],
			'contentOptions'=>['style'=>'width: 70px;']
        ],		
    ],
]) ?>
