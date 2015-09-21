<?
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Фон';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Фон</h1>
<?= Html::a('Создать', ['/admin/bg/save'], ['class'=>'btn btn-success']) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
		[
		'attribute' => 'id',
		'value'=>'id',
		'contentOptions'=>['style'=>'width: 70px;']
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
