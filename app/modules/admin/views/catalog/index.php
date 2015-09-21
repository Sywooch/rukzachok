<?
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Каталог</h1>
<?= Html::a('Создать', ['/admin/catalog/save'], ['class'=>'btn btn-success']) ?>
<?
echo GridView::widget([
    'dataProvider' =>$dataCatalog,
    'columns' => [
		[
		'attribute' => 'id',
		'value'=>'id',
		'contentOptions'=>['style'=>'width: 70px;']
		],
		[
		'attribute' => 'name',
		'value'=>function($data){
                            return Html::a($data->name, ['/admin/products/index','catID'=>$data->id,'catParentID'=>$data->parent_id]);
                        },
                'format'=>'raw',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],		
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{fasovka}&nbsp;&nbsp;{type}&nbsp;&nbsp;{brends}',
            'buttons' => [
                        'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/catalog/save','id'=>$model->id], 
                        [
                            'title' => "Редактировать",
                        ]);
                    },
                'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/catalog/delete','id'=>$model->id], 
                        [
                            'title' => "Удалить",
                            'data-confirm' => 'Желаете удалить запись?',
                        ]);
                    },
                'fasovka' => function ($url, $model) {
                        return Html::a('Фильтры', ['/admin/filters/index','catID'=>$model->id], 
                        [
                            'title' => "Фильтры",
                        ]);
                    },
                'type' => function ($url, $model) {
                        return Html::a('Тип', ['/admin/type/index','catID'=>$model->id], 
                        [
                            'title' => "Тип",
                        ]);
                    },
                     
                ],
			'contentOptions'=>['style'=>'width: 270px;']
        ],		
    ],
]) ?>
