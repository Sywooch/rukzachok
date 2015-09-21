<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\models\User;
use app\models\Order;
use app\models\OrdersProducts;
use app\models\Share;
use app\models\Price;


class IamController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['person'],
                'rules' => [
                    [
                        'actions' => ['index','edit','myorders','show_order','share','price'],
                        'allow' => true,
                        'roles' => ['@'],
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
            

		$model = User::findOne(Yii::$app->user->id);


		return $this->render(Yii::$app->user->identity->role, [
                'model' => $model,
            ]);
    }
	
    public function actionEdit()
    {
            

		$model = User::findOne(Yii::$app->user->id);
		
		$model->scenario = 'edit_'.Yii::$app->user->identity->role;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {

				return Yii::$app->response->redirect(['/iam/index']);
					
			
		}		
		
		return $this->render('edit_'.Yii::$app->user->identity->role, [
                'model' => $model,
            ]);
    }
    
    public function actionMyorders(){
           

                $model = Order::find()->where(['user_id'=>Yii::$app->user->id])->orderBy('id DESC')->all();

       return $this->render('myorders',['model'=>$model]);
                
    }
    
    public function actionShow_order()
    {
		$model = Order::findOne($_GET['id']);
                

                
                $dataProvider = new ActiveDataProvider([
			'query' => OrdersProducts::find()->where(['order_id'=>$_GET['id']]),
			'pagination' => [
				'pageSize' => 20,
			],
		]);
        return $this->render('show_order',['model'=>$model,'dataProvider'=>$dataProvider]);
    }
    
    public function actionShare(){
                if(!empty($_GET['id'])){
                    if(!$model = Share::find()->where('user_id=:user_id and product_id=:product_id',[':user_id'=>Yii::$app->user->id,':product_id'=>$_GET['id']])->one())
                            $model = new Share;
                    
                    $model->product_id = $_GET['id'];
                    $model->save();
                    
                    Yii::$app->getSession()->setFlash('success', 'Этот товар добавлен в закладку!');
                    return $this->redirect(Yii::$app->request->referrer);
                }
                else{
                   /* $dataProvider = new ActiveDataProvider([
                            'query' => Share::find()->where(['user_id'=>Yii::$app->user->id])->orderBy('date_time DESC'),
                            'pagination' => [
                                    'pageSize' => 20,
                            ],
                    ]);*/
                    if(!empty($_GET['deleteID'])){
                        $model = Share::find()->where(['user_id'=>Yii::$app->user->id,'id'=>$_GET['deleteID']])->one();
                        $model->delete();
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                    $query = Share::find()->where(['user_id'=>Yii::$app->user->id])->groupBy('date')->orderBy('date DESC');
                    $countQuery = clone $query;
                    $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>20]);
                    $pages->forcePageParam = false;
                    $pages->pageSizeParam = false;
                    $share = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                return $this->render('share',['share'=>$share,'pages'=>$pages]);
                }        
    }
    
    
    public function actionPrice(){
                if(!empty($_GET['id'])){
                    if(!$model = Price::find()->where('user_id=:user_id and product_id=:product_id',[':user_id'=>Yii::$app->user->id,':product_id'=>$_GET['id']])->one())
                            $model = new Price;
                    
                    $model->product_id = $_GET['id'];
                    $model->save();
                    
                    Yii::$app->getSession()->setFlash('success', 'Этот товар добавлен в закладку Узнать о снижение цены!');
                    return $this->redirect(Yii::$app->request->referrer);
                }
                else{
                    $dataProvider = new ActiveDataProvider([
                            'query' => Price::find()->where(['user_id'=>Yii::$app->user->id])->orderBy('date_time DESC'),
                            'pagination' => [
                                    'pageSize' => 20,
                            ],
                    ]);
                return $this->render('price',['dataProvider'=>$dataProvider]);
                }        
    }    
    
}