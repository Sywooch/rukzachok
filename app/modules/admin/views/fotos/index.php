<?
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Фотос';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Фотос</h1>
<?= Html::a('Вернуться к продуктат', ['/admin/products/index','catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']], ['class'=>'btn btn-info']) ?>

<?= Html::a('Создать', ['/admin/fotos/save','productID'=>$_GET['productID'],'catID'=>$_GET['catID']], ['class'=>'btn btn-success']) ?>
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
		'attribute' => 'image',
                'format' => 'image',    
		'value'=>function($data) { return Yii::$app->request->BaseUrl.'/upload/fotos/ico/'.$data->image; },
		'contentOptions'=>['style'=>'width: 100px;']
		],         
        
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}',
			        'buttons' => [
                        'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/fotos/save','id'=>$model->id,'productID'=>$_GET['productID'],'catID'=>$_GET['catID']], 
                        [
                            'title' => "Редактировать",
                        ]);
                    },
                'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/fotos/delete','id'=>$model->id,'productID'=>$_GET['productID'],'catID'=>$_GET['catID']], 
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
