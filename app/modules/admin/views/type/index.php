<?
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Тип';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Тип</h1>

<?= Html::a('Создать', ['/admin/type/save','catID'=>$_GET['catID']], ['class'=>'btn btn-success']) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
		[
		'attribute' => 'id',
		'value'=>'id',
		'contentOptions'=>['style'=>'width: 70px;']
		],
		[
		'attribute' => 'name',
		'value'=>'name',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],
       
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}',
			        'buttons' => [
                        'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/type/save','id'=>$model->id,'catID'=>$_GET['catID']], 
                        [
                            'title' => "Редактировать",
                        ]);
                    },
                'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/type/delete','id'=>$model->id,'catID'=>$_GET['catID']], 
                        [
                            'title' => "Удалить",
                            'data-confirm' => 'Желаете удалить запись?',
                        ]);
                    },
                           
                ],
			'contentOptions'=>['style'=>'width: 70px;']
        ],		
    ],
]) ?>