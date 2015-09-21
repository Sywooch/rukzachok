<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Label;
use yii\bootstrap\Modal;
$this->registerJsFile('/app/modules/admin/assets/js/jquery-1.11.3.min.js');
$this->registerJsFile('/app/modules/admin/assets/js/site.js');


$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Заказы</h1>

	<?php $form = ActiveForm::begin(['id' => 'label-form','method'=>'get','action'=>['/admin/orders/index']]); ?>
		
        <?php 
            $arr = [];
            foreach(Label::find()->orderBy('id')->all() as $item)
            {
                $arr[] = ['id'=>$item->id,'label'=>$item->label.'-'.$item->name];
            }
            echo $form->field($searchModel, 'labels')->inline(true)->checkboxList(ArrayHelper::map($arr, 'id', 'label'),['onClick'=>'$("#label-form").submit()']); 
        ?>

    <?php ActiveForm::end(); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
       // ['class' => 'yii\grid\SerialColumn'],

		[
                'attribute' => 'id',
                'format' => 'raw',
                'options' => ['class' => 'btn btn-warning'],
                'value' => function($model){
                    return Html::button($model->id, ['id'=>$model->id, 'class' => 'btn btn-warning']); '/admin/orders/show?id=47';
                 //return Html::a($model->id, ['/admin/orders/show', 'id'=>$model->id], ['class'=>'btn btn-warning'] );
                // return Html::a($data->name, ['/admin/orders/show','id'=>$data->id]);
                }

            ],
		/*[
		'attribute' =>'username',
		'value'=>function($data){
                            if(!empty($data->user->username))return Html::a($data->user->username, ['/admin/users/show','id'=>$data->user->id]);
                        },
                'format'=>'raw',                
		//'contentOptions'=>['style'=>'width: 160px;']
		], */       
		[
		'attribute' => 'date_time',
		'value'=>'date_time',
		],
		[
		'attribute' => 'surname',
		'value'=>'surname',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],        
		[
		'attribute' => 'name',
		'value'=>function($data){
                            return Html::a($data->name, ['/admin/orders/show','id'=>$data->id]);
                        },
                'format'=>'raw',
		],
		[
		'attribute' => 'phone',
		'value'=>'phone',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],
		[
		'attribute' => 'total',
		'value'=>'total',
		//'contentOptions'=>['style'=>'max-width: 300px;']
		],
		[
		'attribute' => 'label',
                'value' => function ($model, $key, $index, $column) {
                        //  var_dump($model); var_dump($key); exit;
                        return Html::activeDropDownList($model, 'label',
                            yii\helpers\ArrayHelper::map(Label::find()->orderBy('id')->asArray()->all(), 'id', 'label'),
                            [
                                'prompt' => 'Нет',
                                'onchange' => "$.ajax({
                                     url: \"/admin/orders/labelupdate\",
                                     type: \"post\",
                                     data: { order_id:  $model->id, label_id : this.value},
                                    });"
                            ]

                        );
                    },
                'format' => 'raw',  
		],
		[
		'attribute' => 'status',
		'value'=>'status',
		'contentOptions'=>['style'=>'width: 5px;']
		],                                 
        [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'contentOptions'=>['style'=>'width: 70px;']
        ],		
    ],
]) ?>
