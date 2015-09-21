<?
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Продукты</h1>
<?= Html::a('Создать', ['/admin/products/save','catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']], ['class'=>'btn btn-success']) ?>
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
		'attribute' => 'name',
		'value'=>'name',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],		
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{mod}&nbsp;&nbsp;{fotos}',
			        'buttons' => [
                        'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/products/save','id'=>$model->id,'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']], 
                        [
                            'title' => "Редактировать",
                        ]);
                    },
                'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/products/delete','id'=>$model->id,'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']], 
                        [
                            'title' => "Удалить",
                            'data-confirm' => 'Желаете удалить запись?',
                        ]);
                    },
                'mod' => function ($url, $model) {
                        return Html::a('Модификации', ['/admin/mod/index','productID'=>$model->id,'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']], 
                        [
                            'title' => "Модификации",
                        ]);
                    },
                'fotos' => function ($url, $model) {
                        return Html::a('Фотос', ['/admin/fotos/index','productID'=>$model->id,'catID'=>$_GET['catID'],'catParentID'=>$_GET['catParentID']], 
                        [
                            'title' => "Фотос",
                        ]);
                    }                            
                ],
			'contentOptions'=>['style'=>'width: 270px;']
        ],		
    ],
]) ?>
