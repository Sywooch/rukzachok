<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;
use app\modules\admin\models\Orders;
use app\modules\admin\models\OrdersProducts;
use app\modules\admin\models\Mod;
use app\modules\admin\models\Label;


class OrdersController extends Controller
{
    public $layout = 'update';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['index','save','delete','show','add','delete_product','labelupdate'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],					
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
	
    public function actionIndex()
    {        
                $searchModel = new Orders;
                $searchModel->load(Yii::$app->request->queryParams);
                $query = Orders::find(); 
                if(!empty($searchModel->labels))$query->andWhere(['label'=>$searchModel->labels]);
                //if(!empty($searchModel->date_time))$query->andFilterWhere(['like', 'date_time', $searchModel->date_time]);
                if(!empty($searchModel->username))$query->andFilterWhere(['like', 'username', $searchModel->username]);
                if(!empty($searchModel->id))$query->andFilterWhere(['like', 'id', $searchModel->id]);
		        if(!empty($searchModel->phone))$query->andFilterWhere(['like', 'phone', $searchModel->phone]);
                if(!empty($searchModel->name))$query->andFilterWhere(['like', 'name', $searchModel->name]);
                if(!empty($searchModel->surname))$query->andFilterWhere(['like', 'surname', $searchModel->surname]);
                if(!empty($searchModel->total))$query->andFilterWhere(['like', 'total', $searchModel->total]);
                if(!empty($searchModel->reserve))$query->andFilterWhere(['like', 'reserve', $searchModel->reserve]);
                if(!empty($searchModel->status))$query->andFilterWhere(['like', 'status', $searchModel->status]);
                
// var_dump($searchModel->name);
// die;
                $dataProvider = new ActiveDataProvider([
			'query' =>$query,
                        'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
			'pagination' => [
				'pageSize' => 20,
			],
		]);
                
        return $this->render('index', [
            'dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel,
            ]);
    }
	
    public function actionShow($id)
    {

		$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('show', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionLabelupdate(){
        $model = Orders::findOne($_POST['order_id']);
        $model->label = $_POST['label_id'];
        $model->save();
        Yii::$app->and();
    }

	public function actionDelete(){
		$model = Orders::findOne($_GET['id']);
		$model->delete();
		return Yii::$app->response->redirect(['/admin/orders/index']);
	}
        
        
        public function actionAdd(){
            $model = new OrdersProducts;
            
		if ($model->load(Yii::$app->request->post())) {
                        if(!$modelMod = Mod::find()->with(['product'])->where(['art'=>$model->art])->one())
                                throw new HttpException(404, 'Данного артикля не существует!');
                        $model->product_name = $modelMod->product->name;
                        $model->name = $modelMod->name;
                        $model->art = $modelMod->art;
                        $model->cost = $modelMod->cost;
                        $model->sum_cost = $model->count*$modelMod->cost;
                        $model->save();
			return Yii::$app->response->redirect(['/admin/orders/show','id'=>$_GET['order_id']]);
		}            
            
            return $this->render('add',['model'=>$model]);
        }
        
	public function actionDelete_product(){
		$model = OrdersProducts::findOne($_GET['id']);
		$model->delete();
		return Yii::$app->response->redirect(['/admin/orders/show','id'=>$_GET['order_id']]);
	}  

    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }      
}
