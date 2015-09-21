<?
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Модификации';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Модификации</h1>
<?= Html::a('Вернуться к продуктат', ['/admin/products/index','catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']], ['class'=>'btn btn-info']) ?>

<?= Html::a('Создать', ['/admin/mod/save','productID'=>$_GET['productID'],'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']], ['class'=>'btn btn-success']) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
		[
		'attribute' => 'id',
		'value'=>'id',
		'contentOptions'=>['style'=>'width: 70px;']
		],
		[
		'attribute' => 'art',
		'value'=>'art',
		'contentOptions'=>['style'=>'width: 100px;']
		],
        [
            'attribute' => 'image',
            'format' => 'image',
            'value'=>function($data) { return Yii::$app->request->BaseUrl.'/upload/mod/ico/'.$data->image; },
            'contentOptions'=>['style'=>'width: 100px;'],
            'filter'=>false,
        ],
        [
            'attribute' => 'size',
            'value'=>'size',
            'contentOptions'=>['style'=>'width: 100px;'],
            'filter'=>false,
        ],
        [
            'attribute' => 'color',
            'value'=>'color',
            'contentOptions'=>['style'=>'width: 100px;'],
            'filter'=>false,
        ],
		[
		'attribute' => 'cost',
		'value'=>'cost',
		'contentOptions'=>['style'=>'width: 170px;'],
            'filter'=>false,
		],
        [
            'attribute' => 'active',
            'value'=>function($data) { return ($data->active==0) ? 'есть' : 'нет'; },
            'contentOptions'=>['style'=>'width: 100px;'],
            'filter'=>false,
        ],
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}',
			        'buttons' => [
                        'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/mod/save','id'=>$model->id,'productID'=>$_GET['productID'],'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']],
                        [
                            'title' => "Редактировать",
                        ]);
                    },
                'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/mod/delete','id'=>$model->id,'productID'=>$_GET['productID'],'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']],
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
